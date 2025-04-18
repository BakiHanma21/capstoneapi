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

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time().'.'.$file->extension();
            $file->move(public_path('storage/images'), $imageName);
            $imagePath = "images/" . $imageName;
        } else {
            $imagePath = null;
        }
        
        $start = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d H:i:s');
        $end = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d H:i:s');
        $start_time = $request->time;

        $booking = Booking::create([
            'worker_id' => $worker->id,
            'customer_id' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->cost,
            'start' => $start,
            'start_time' => $request->time,
            'end' => $end,
            'status' => "PENDING",
            'image' => $imagePath,
        ]);

        return response()->json($booking, 201);
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

            // Get all confirmed bookings for the worker
            $events = Booking::where('status', 'CONFIRMED')
                           ->where('worker_id', $user->id)
                           ->get();

            return EventResource::collection($events);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching events.', 'message' => $e->getMessage()], 500);
        }
    }

}
