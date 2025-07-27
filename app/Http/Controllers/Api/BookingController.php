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
use Illuminate\Support\Facades\Log;
use App\Services\FirebaseService;
use App\Notifications\BookingRequestNotification;
use App\Notifications\BookingApprovedNotification;
use App\Notifications\BookingDeclinedNotification;

class BookingController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

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
            'description' => 'required|string|max:1000', // Updated to max:1000
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cost' => 'required|numeric',
            'time' => 'required|date_format:H:i',
            'force_booking' => 'nullable|string',
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

        // Only block booking if there are conflicts AND force_booking is not set
        if (!empty($conflicts['conflicts']) && $request->force_booking !== 'true') {
            return response()->json([
                'error' => 'Scheduling Conflict',
                'message' => 'The worker is not available for the selected date and time',
                'conflicts' => $conflicts['conflicts']
            ], 409);
        }
        
        // If force_booking is true, we'll allow the booking to proceed even with conflicts
        // The worker can still approve or decline the request

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

        // Send push notification to worker about the new booking request
        $this->sendPushNotificationToWorker($booking, $worker);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking
        ], 201);
    }

    /**
     * Send push notification to worker about new booking request
     */
    private function sendPushNotificationToWorker($booking, $worker)
    {
        $customer = User::find($booking->customer_id);
        
        // Create database notification for worker
        $workerUser = User::find($worker->id);
        if ($workerUser) {
            // Use the exact booking creation time for accurate timestamps
            $exactRequestTime = $booking->created_at;
            
            $workerUser->notify(new BookingRequestNotification(
                $booking,
                $worker,
                $customer
            ));
            
            Log::info('Database notification created for worker with timestamp', [
                'worker_id' => $worker->id,
                'booking_id' => $booking->booking_id,
                'timestamp' => $exactRequestTime->toIso8601String()
            ]);
        }
        
        // Also create a notification for the customer about their booking request
        if ($customer) {
            // Create a notification object for the customer
            $customerNotification = new \stdClass();
            $customerNotification->title = "🛠 New Booking Request Sent";
            $customerNotification->body = "You have sent a booking request for {$booking->title} to {$worker->name}.";
            $customerNotification->notification_type = 'new_booking_request';
            $customerNotification->data = [
                'booking_id' => $booking->booking_id,
                'worker_id' => $worker->id,
                'worker_name' => $worker->name,
                'timestamp' => $booking->created_at->toIso8601String()
            ];
            
            // Store notification in database for customer
            $customer->notify(new \App\Notifications\GenericNotification($customerNotification));
            
            Log::info('Database notification created for customer about their booking request', [
                'customer_id' => $customer->id,
                'booking_id' => $booking->booking_id,
                'timestamp' => $booking->created_at->toIso8601String()
            ]);
            
            // Send push notification to customer if they have a device token
            if ($customer->device_token) {
                $this->firebaseService->sendNotification(
                    $customer->device_token,
                    [
                        'title' => $customerNotification->title,
                        'body' => $customerNotification->body
                    ],
                    [
                        'booking_id' => $booking->booking_id,
                        'worker_id' => $worker->id,
                        'worker_name' => $worker->name,
                        'notification_type' => 'new_booking_request',
                        'timestamp' => $booking->created_at->toIso8601String()
                    ],
                    $customer->device_type
                );
            }
        }
        
        // Skip push notification if no device token
        if (!$worker->device_token) {
            Log::info('Worker has no device token, skipping push notification', [
                'worker_id' => $worker->id,
                'worker_name' => $worker->name
            ]);
            return false;
        }
        
        // Create notification payload with accurate timestamp
        $notification = [
            'title' => '🛠 New Booking Request',
            'body' => 'You have a new booking request from ' . $customer->name . ' for ' . $booking->title . ' job.'
        ];
        
        // Use the exact booking creation time for accurate timestamps
        $exactRequestTime = $booking->created_at;
        
        $data = [
            'booking_id' => $booking->booking_id,
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'notification_type' => 'new_booking_request',
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'timestamp' => $exactRequestTime->toIso8601String() // Exact booking request time
        ];
        
        try {
            $this->firebaseService->sendNotification(
                $worker->device_token, 
                $notification, 
                $data, 
                $worker->device_type
            );
            
            Log::info('Push notification sent to worker with timestamp', [
                'worker_id' => $worker->id,
                'worker_name' => $worker->name,
                'booking_id' => $booking->booking_id,
                'device_type' => $worker->device_type,
                'timestamp' => $exactRequestTime->toIso8601String()
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send push notification to worker', [
                'error' => $e->getMessage(),
                'worker_id' => $worker->id
            ]);
            
            return false;
        }
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
        $oldStatus = $booking->status;
        $booking->update($request->validated());
        
        // Check if status has changed to CONFIRMED or CANCELLED
        if ($oldStatus !== $booking->status) {
            if ($booking->status === 'CONFIRMED') {
                // Send notification to customer about booking approval
                $this->sendBookingApprovalNotification($booking);
            } elseif ($booking->status === 'CANCELLED') {
                // Send notification to customer about booking decline
                $this->sendBookingDeclinedNotification($booking);
            }
        }

        return $booking;
    }

    /**
     * Send notification to customer when booking is approved
     */
    private function sendBookingApprovalNotification(Booking $booking)
    {
        $customer = User::find($booking->customer_id);
        $worker = User::find($booking->worker_id);
        
        // Use current time as the exact approval timestamp
        $approvalTimestamp = now();
        
        // Create database notification for customer
        if ($customer) {
            $customer->notify(new BookingApprovedNotification(
                $booking,
                $worker,
                $customer
            ));
            
            Log::info('Database notification created for booking approval with timestamp', [
                'customer_id' => $customer->id,
                'booking_id' => $booking->booking_id,
                'timestamp' => $approvalTimestamp->toIso8601String()
            ]);
        }
        
        // Also create a notification for the worker about their approval
        if ($worker) {
            // Create a notification object for the worker
            $workerNotification = new \stdClass();
            $workerNotification->title = "✅ Booking Approved";
            $workerNotification->body = "You have approved a booking request from {$customer->name} for {$booking->title}.";
            $workerNotification->notification_type = 'booking_approved';
            
            // Add flags to ensure the notification is persistent for workers
            $workerNotification->persistent = true;
            $workerNotification->for_worker = true;
            $workerNotification->persist_for_worker = true;
            
            $workerNotification->data = [
                'booking_id' => $booking->booking_id,
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'timestamp' => $approvalTimestamp->toIso8601String(),
                'persistent' => true,
                'for_worker' => true,
                'persist_for_worker' => true
            ];
            
            // Store notification in database for worker
            $worker->notify(new \App\Notifications\GenericNotification($workerNotification));
            
            Log::info('Persistent notification created for worker about booking approval', [
                'worker_id' => $worker->id,
                'booking_id' => $booking->booking_id,
                'timestamp' => $approvalTimestamp->toIso8601String(),
                'persistent' => true
            ]);
            
            // Send push notification to worker if they have a device token
            if ($worker->device_token) {
                $this->firebaseService->sendNotification(
                    $worker->device_token,
                    [
                        'title' => $workerNotification->title,
                        'body' => $workerNotification->body
                    ],
                    [
                        'booking_id' => $booking->booking_id,
                        'customer_id' => $customer->id,
                        'customer_name' => $customer->name,
                        'notification_type' => 'booking_approved',
                        'timestamp' => $approvalTimestamp->toIso8601String(),
                        'persistent' => true,
                        'for_worker' => true,
                        'persist_for_worker' => true
                    ],
                    $worker->device_type
                );
            }
        }
        
        // Skip push notification if no device token
        if (!$customer || !$customer->device_token) {
            Log::info('Customer has no device token, skipping approval notification', [
                'customer_id' => $booking->customer_id,
                'booking_id' => $booking->booking_id
            ]);
            return false;
        }
        
        $notification = [
            'title' => '✅ Booking Approved',
            'body' => "Your booking request for {$booking->title} has been approved by {$worker->name}."
        ];
        
        $data = [
            'booking_id' => $booking->booking_id,
            'worker_id' => $worker->id,
            'worker_name' => $worker->name,
            'notification_type' => 'booking_approved',
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'timestamp' => $approvalTimestamp->toIso8601String() // Exact approval timestamp
        ];
        
        try {
            $this->firebaseService->sendNotification(
                $customer->device_token, 
                $notification, 
                $data, 
                $customer->device_type
            );
            
            Log::info('Booking approval notification sent to customer with timestamp', [
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'booking_id' => $booking->booking_id,
                'timestamp' => $approvalTimestamp->toIso8601String()
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send booking approval notification', [
                'error' => $e->getMessage(),
                'customer_id' => $customer->id
            ]);
            
            return false;
        }
    }

    /**
     * Send notification to customer when booking is declined
     */
    private function sendBookingDeclinedNotification(Booking $booking)
    {
        $customer = User::find($booking->customer_id);
        $worker = User::find($booking->worker_id);
        
        // Use current time as the exact decline timestamp
        $declineTimestamp = now();
        
        // Create database notification for customer
        if ($customer) {
            $customer->notify(new BookingDeclinedNotification(
                $booking,
                $worker,
                $customer
            ));
            
            Log::info('Database notification created for booking decline with timestamp', [
                'customer_id' => $customer->id,
                'booking_id' => $booking->booking_id,
                'timestamp' => $declineTimestamp->toIso8601String()
            ]);
        }
        
        // Also create a notification for the worker about their decline
        if ($worker) {
            // Create a notification object for the worker
            $workerNotification = new \stdClass();
            $workerNotification->title = "❌ Booking Declined";
            $workerNotification->body = "You have declined a booking request from {$customer->name} for {$booking->title}.";
            $workerNotification->notification_type = 'booking_declined';
            
            // Add flags to ensure the notification is persistent for workers
            $workerNotification->persistent = true;
            $workerNotification->for_worker = true;
            $workerNotification->persist_for_worker = true;
            
            $workerNotification->data = [
                'booking_id' => $booking->booking_id,
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'timestamp' => $declineTimestamp->toIso8601String(),
                'persistent' => true,
                'for_worker' => true,
                'persist_for_worker' => true
            ];
            
            // Add decline reason if available
            if (!empty($booking->decline_reason)) {
                $workerNotification->data['decline_reason'] = $booking->decline_reason;
            }
            
            // Store notification in database for worker
            $worker->notify(new \App\Notifications\GenericNotification($workerNotification));
            
            Log::info('Persistent notification created for worker about booking decline', [
                'worker_id' => $worker->id,
                'booking_id' => $booking->booking_id,
                'timestamp' => $declineTimestamp->toIso8601String(),
                'persistent' => true
            ]);
            
            // Send push notification to worker if they have a device token
            if ($worker->device_token) {
                // Prepare push notification data
                $pushData = [
                    'booking_id' => $booking->booking_id,
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->name,
                    'notification_type' => 'booking_declined',
                    'timestamp' => $declineTimestamp->toIso8601String(),
                    'persistent' => true,
                    'for_worker' => true,
                    'persist_for_worker' => true
                ];
                
                // Add decline reason if available
                if (!empty($booking->decline_reason)) {
                    $pushData['decline_reason'] = $booking->decline_reason;
                }
                
                $this->firebaseService->sendNotification(
                    $worker->device_token,
                    [
                        'title' => $workerNotification->title,
                        'body' => $workerNotification->body
                    ],
                    $pushData,
                    $worker->device_type
                );
            }
        }
        
        // Skip push notification if no device token
        if (!$customer || !$customer->device_token) {
            Log::info('Customer has no device token, skipping decline notification', [
                'customer_id' => $booking->customer_id,
                'booking_id' => $booking->booking_id
            ]);
            return false;
        }
        
        $notification = [
            'title' => '❌ Booking Declined',
            'body' => "Your booking request for {$booking->title} has been declined by {$worker->name}."
        ];
        
        $data = [
            'booking_id' => $booking->booking_id,
            'worker_id' => $worker->id,
            'worker_name' => $worker->name,
            'notification_type' => 'booking_declined',
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'timestamp' => $declineTimestamp->toIso8601String() // Exact decline timestamp
        ];
        
        try {
            $this->firebaseService->sendNotification(
                $customer->device_token, 
                $notification, 
                $data, 
                $customer->device_type
            );
            
            Log::info('Booking decline notification sent to customer with timestamp', [
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'booking_id' => $booking->booking_id,
                'timestamp' => $declineTimestamp->toIso8601String()
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send booking decline notification', [
                'error' => $e->getMessage(),
                'customer_id' => $customer->id
            ]);
            
            return false;
        }
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

    /**
     * Get bookings for a specific user with optional worker filter
     */
    public function getUserBookings($userId, Request $request)
    {
        // Verify that the user exists
        $user = User::where('id', $userId)->first();
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Build the query to get user's bookings
        $query = Booking::where('customer_id', $userId);
        
        // Filter by worker_id if provided
        if ($request->has('worker_id')) {
            $query->where('worker_id', $request->worker_id);
        }
        
        // Get the bookings with pagination
        $bookings = $query->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'data' => $bookings,
            'message' => 'User bookings retrieved successfully'
        ]);
    }

    /**
     * Cancel a booking by the client
     * 
     * @param int $bookingId
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelBooking($bookingId)
    {
        try {
            // Find booking and verify ownership
            $booking = Booking::findOrFail($bookingId);
            
            // Ensure the authenticated user is the one who made this booking
            if ($booking->customer_id != Auth::id()) {
                return response()->json([
                    'error' => 'Unauthorized action',
                    'message' => 'You can only cancel your own bookings'
                ], 403);
            }
            
            // Set the booking status to CANCELLED
            $booking->status = 'CANCELLED';
            $booking->save();
            
            // Get worker details for the notification
            $worker = User::find($booking->worker_id);
            $customer = User::find($booking->customer_id);
            
            // Create database notification
            if ($worker) {
                // Create timestamp for the cancellation
                $cancelTimestamp = now();
                
                // Send notification to worker about the cancellation
                $notification = [
                    'title' => 'Booking Cancelled by ' . $customer->name,
                    'body' => $customer->name . ' has cancelled the booking for ' . $booking->title . ' scheduled on ' . 
                            Carbon::parse($booking->start)->format('F j, Y') . ' at ' . 
                            Carbon::parse($booking->start_time)->format('h:i A'),
                    'notification_type' => 'booking_cancelled',
                    'data' => [
                        'booking_id' => $booking->booking_id,
                        'customer_id' => $customer->id,
                        'customer_name' => $customer->name
                    ],
                    'timestamp' => $cancelTimestamp->toIso8601String()
                ];
                
                if ($worker->device_token) {
                    // Send push notification to worker
                    $this->firebaseService->sendNotification(
                        $worker->device_token,
                        [
                            'title' => $notification['title'],
                            'body' => $notification['body']
                        ],
                        [
                            'booking_id' => $booking->booking_id,
                            'customer_id' => $customer->id,
                            'customer_name' => $customer->name,
                            'notification_type' => 'booking_cancelled',
                            'timestamp' => $cancelTimestamp->toIso8601String()
                        ],
                        $worker->device_type
                    );
                }
                
                // Add to database notifications
                $worker->notify(new \App\Notifications\GenericNotification((object) $notification));
            }
            
            // Create notification for client as well
            if ($customer) {
                // Create timestamp for the cancellation
                $cancelTimestamp = now();
                
                // Send notification to customer about their cancellation
                $notification = [
                    'title' => 'You Cancelled a Booking',
                    'body' => 'You have successfully cancelled your booking for ' . $booking->title . ' with ' . 
                            $worker->name . ' scheduled on ' . 
                            Carbon::parse($booking->start)->format('F j, Y') . ' at ' . 
                            Carbon::parse($booking->start_time)->format('h:i A'),
                    'notification_type' => 'booking_cancelled',
                    'data' => [
                        'booking_id' => $booking->booking_id,
                        'worker_id' => $worker->id,
                        'worker_name' => $worker->name
                    ],
                    'timestamp' => $cancelTimestamp->toIso8601String()
                ];
                
                if ($customer->device_token) {
                    // Send push notification to customer
                    $this->firebaseService->sendNotification(
                        $customer->device_token,
                        [
                            'title' => $notification['title'],
                            'body' => $notification['body']
                        ],
                        [
                            'booking_id' => $booking->booking_id,
                            'worker_id' => $worker->id,
                            'worker_name' => $worker->name,
                            'notification_type' => 'booking_cancelled',
                            'timestamp' => $cancelTimestamp->toIso8601String()
                        ],
                        $customer->device_type
                    );
                }
                
                // Add to database notifications
                $customer->notify(new \App\Notifications\GenericNotification((object) $notification));
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully',
                'booking' => $booking
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error cancelling booking', [
                'booking_id' => $bookingId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Failed to cancel booking',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}