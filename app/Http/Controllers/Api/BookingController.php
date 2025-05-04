<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Models\Transaction;
use App\Models\SkilledWorker;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * @group Booking API
     * 
     * Get All Booking
     */
    public function index(Request $request)
    {
        $bookings = Booking::paginate();

        return BookingResource::collection($bookings);
    }

    /**
     * Check if worker has existing bookings or transactions for the given date and time
     */
    private function checkWorkerAvailability($workerId, $startDate, $endDate, $startTime)
    {
        // Convert start time to DateTime
        $startDateTime = Carbon::parse($startDate . ' ' . $startTime);
        $endDateTime = Carbon::parse($endDate . ' ' . $startTime);

        // Check existing bookings
        $existingBookings = Booking::where('worker_id', $workerId)
            ->where('status', 'CONFIRMED')
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->whereBetween('start', [$startDateTime, $endDateTime])
                    ->orWhereBetween('end', [$startDateTime, $endDateTime])
                    ->orWhere(function ($q) use ($startDateTime, $endDateTime) {
                        $q->where('start', '<=', $startDateTime)
                            ->where('end', '>=', $endDateTime);
                    });
            })
            ->get();

        // Check existing transactions (accepted bookings)
        $existingTransactions = Transaction::where('request_id', $workerId)
            ->whereDate('payment_date', '>=', $startDateTime)
            ->whereDate('payment_date', '<=', $endDateTime)
            ->where('payment_status', 'PAID')
            ->get();

        $conflicts = [];

        if ($existingBookings->isNotEmpty()) {
            foreach ($existingBookings as $booking) {
                $conflicts[] = [
                    'type' => 'booking',
                    'date' => Carbon::parse($booking->start)->format('Y-m-d'),
                    'time' => Carbon::parse($booking->start_time)->format('H:i'),
                    'title' => $booking->title
                ];
            }
        }

        if ($existingTransactions->isNotEmpty()) {
            foreach ($existingTransactions as $transaction) {
                $conflicts[] = [
                    'type' => 'transaction',
                    'date' => Carbon::parse($transaction->payment_date)->format('Y-m-d'),
                    'title' => $transaction->title
                ];
            }
        }

        return [
            'isAvailable' => empty($conflicts),
            'conflicts' => $conflicts
        ];
    }

    /**
     * @group Booking API
     * 
     * Store Booking
     */
    public function store(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cost' => 'required|numeric',
            'time' => 'required|date_format:H:i',
        ]);

        // Verify that the worker exists and is actually a worker
        $worker = User::where('id', $request->worker_id)
                     ->where('role', 'WORKER')
                     ->firstOrFail();

        // Check for scheduling conflicts
        $conflicts = $this->checkWorkerAvailability(
            $request->worker_id,
            $request->start_date,
            $request->end_date,
            $request->time
        );

        if (!empty($conflicts['conflicts'])) {
            return response()->json([
                'error' => 'Scheduling Conflict',
                'message' => 'The worker is not available for the selected date and time',
                'conflicts' => $conflicts['conflicts']
            ], 409);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time().'.'.$file->extension();
            $file->move(public_path('storage/images'), $imageName);
            $imagePath = "images/" . $imageName;
        } else {
            $imagePath = null;
        }
        
        $start = Carbon::parse($request->start_date)->format('Y-m-d H:i:s');
        $end = Carbon::parse($request->end_date)->format('Y-m-d H:i:s');

        $booking = Booking::create([
            'worker_id' => $worker->id,
            'customer_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->cost,
            'start' => $start,
            'start_time' => $request->time,
            'end' => $end,
            'status' => "PENDING",
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking
        ], 201);
    }

    /**
     * @group Booking API
     * 
     * Show Booking
     */
    public function show(Booking $booking): Booking
    {
        return $booking;
    }

     /**
     * @group Booking API
     * 
     * Update Booking
     */
    public function update(BookingRequest $request, Booking $booking): Booking
    {
        $booking->update($request->validated());

        return $booking;
    }

    /**
     * @group Booking API
     * 
     * Delete Booking
     */
    public function destroy(Booking $booking): Response
    {
        $booking->delete();

        return response()->noContent();
    }

    public function getEvents(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['error' => 'Unauthorized!'], 401);
            }

            // Get all confirmed bookings for the worker with customer relationship
            $events = Booking::where('status', 'CONFIRMED')
                           ->where('worker_id', $user->id)
                           ->with('customer') // Include the customer relationship
                           ->get();

            return EventResource::collection($events);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching events.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @group Booking API
     * 
     * Get Worker's Schedule and Transactions
     * 
     * This endpoint returns all confirmed bookings and transactions for a worker
     * to help users see the worker's availability
     */
    public function getWorkerSchedule($workerId)
    {
        try {
            // Verify that the worker exists and is actually a worker
            $worker = User::where('id', $workerId)
                         ->where('role', 'WORKER')
                         ->firstOrFail();

            // Get confirmed bookings
            $confirmedBookings = Booking::where('worker_id', $workerId)
                ->where('status', 'CONFIRMED')
                ->select([
                    'booking_id',
                    'title',
                    'description',
                    'start',
                    'end',
                    'start_time',
                    'amount',
                    'status'
                ])
                ->get()
                ->map(function ($booking) {
                    return [
                        'type' => 'booking',
                        'id' => $booking->booking_id,
                        'title' => $booking->title,
                        'description' => $booking->description,
                        'date' => Carbon::parse($booking->start)->format('Y-m-d'),
                        'start_time' => $booking->start_time,
                        'end_date' => Carbon::parse($booking->end)->format('Y-m-d'),
                        'amount' => $booking->amount,
                        'status' => $booking->status
                    ];
                });

            // Get paid transactions
            $transactions = Transaction::where('request_id', $workerId)
                ->where('payment_status', 'PAID')
                ->select([
                    'transaction_id',
                    'title',
                    'description',
                    'payment_date',
                    'amount',
                    'payment_status'
                ])
                ->get()
                ->map(function ($transaction) {
                    return [
                        'type' => 'transaction',
                        'id' => $transaction->transaction_id,
                        'title' => $transaction->title,
                        'description' => $transaction->description,
                        'date' => Carbon::parse($transaction->payment_date)->format('Y-m-d'),
                        'amount' => $transaction->amount,
                        'status' => $transaction->payment_status
                    ];
                });

            // Combine and sort all schedules by date
            $allSchedules = $confirmedBookings->concat($transactions)
                ->sortBy('date')
                ->values()
                ->all();

            // Get worker's available time slots
            $availableSlots = $this->getWorkerAvailableSlots($workerId, $allSchedules);

            return response()->json([
                'worker_info' => [
                    'id' => $worker->id,
                    'name' => $worker->name,
                    // Add any other relevant worker info
                ],
                'schedules' => $allSchedules,
                'available_slots' => $availableSlots
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch worker schedule',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper function to get available time slots
     * This is a basic implementation - you might want to customize it based on your needs
     */
    private function getWorkerAvailableSlots($workerId, $schedules)
    {
        $today = Carbon::today();
        $twoMonthsFromNow = Carbon::today()->addMonths(2);
        $availableSlots = [];
        
        // Get worker's working hours (you might want to fetch this from worker's profile)
        $workingHours = [
            'start' => '08:00',
            'end' => '17:00'
        ];

        $currentDate = $today->copy();
        while ($currentDate <= $twoMonthsFromNow) {
            $dateStr = $currentDate->format('Y-m-d');
            $daySchedules = collect($schedules)->where('date', $dateStr);
            
            // If no bookings/transactions on this day, it's fully available
            if ($daySchedules->isEmpty()) {
                $availableSlots[] = [
                    'date' => $dateStr,
                    'available_hours' => [
                        [
                            'start' => $workingHours['start'],
                            'end' => $workingHours['end']
                        ]
                    ]
                ];
            } else {
                // Calculate available slots between bookings
                $bookedTimes = $daySchedules->pluck('start_time')->sort()->values();
                $availableHours = [];
                $currentTime = $workingHours['start'];

                foreach ($bookedTimes as $bookedTime) {
                    if ($currentTime < $bookedTime) {
                        $availableHours[] = [
                            'start' => $currentTime,
                            'end' => $bookedTime
                        ];
                    }
                    // Assume each booking takes 1 hour - adjust as needed
                    $currentTime = Carbon::parse($bookedTime)->addHour()->format('H:i');
                }

                // Add remaining time if any
                if ($currentTime < $workingHours['end']) {
                    $availableHours[] = [
                        'start' => $currentTime,
                        'end' => $workingHours['end']
                    ];
                }

                if (!empty($availableHours)) {
                    $availableSlots[] = [
                        'date' => $dateStr,
                        'available_hours' => $availableHours
                    ];
                }
            }

            $currentDate->addDay();
        }

        return $availableSlots;
    }

    /**
     * Check worker availability for a specific date and time (API endpoint)
     */
    public function checkAvailability(Request $request, $workerId)
    {
        try {
            $date = $request->query('date');
            $time = $request->query('time');

            // Validate input
            if (!$date) {
                return response()->json([
                    'error' => 'Date is required'
                ], 400);
            }

            // Use the existing private method
            $availability = $this->checkWorkerAvailability($workerId, $date, $date, $time);

            return response()->json($availability);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to check availability',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
