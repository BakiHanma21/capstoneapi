<?php

namespace App\Http\Controllers\Api;

use App\Models\WorkRequest;
use Illuminate\Http\Request;
use App\Http\Requests\WorkRequestRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkRequestResource;
use App\Http\Resources\WorkerResource;
use Illuminate\Support\Facades\Log;
use App\Models\SkilledWorker;
use App\Models\Worker;
use App\Models\Booking;
use App\Models\User;
use App\Models\Transaction;
use App\Http\Resources\RequestResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseService;

class WorkRequestController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * @group WorkRequest API
     * 
     * Get All WorkRequest
     */
    public function index()
    {
        $workers = SkilledWorker::with('user', 'reviews', 'works')->get();
        return WorkerResource::collection($workers);
    }

    public function destroy($id)
    {
        $worker = SkilledWorker::find($id);

        if (!$worker) {
            return response()->json(['error' => 'Worker not found'], 404);
        }

        $worker->delete();
        return response()->json(['message' => 'Worker deleted successfully']);
    }

    public function postWorker(Request $request)
    {
        $workerData = $request->all();

        return response()->json(['message' => 'Worker posted successfully']);
    }


    public function getWorkerRequests($userId)
    {
        Log::info('User ID: ' . $userId);

        $worker = User::where('id', $userId)
                     ->where('role', 'WORKER')
                     ->firstOrFail();

        // Fetch active requests (removed_at IS NULL)
        $activeRequests = Booking::where('worker_id', $worker->id)
            ->whereNull('removed_at')
            ->with(['customer' => function($query) {
                $query->select('id', 'name', 'image', 'rating', 'phone', 'location', 'purok', 'street', 'email');
            }])
            ->get();

        // Fetch history requests (removed_at IS NOT NULL)
        $historyRequests = Booking::where('worker_id', $worker->id)
            ->whereNotNull('removed_at')
            ->with(['customer' => function($query) {
                $query->select('id', 'name', 'image', 'rating', 'phone', 'location', 'purok', 'street', 'email');
            }])
            ->get();

        // Process active requests
        foreach ($activeRequests as $request) {
            $customer = $request->customer;
            $averageRating = Transaction::where('customer_id', $customer->id)
                                      ->avg('rating');
            $request->average_rating = $averageRating ? number_format($averageRating, 1) : 'Not yet rated';
            $imagePath = $customer->image;
            if ($imagePath) {
                if (!str_starts_with($imagePath, 'http') && !str_starts_with($imagePath, 'storage/')) {
                    if (str_starts_with($imagePath, '/images/') || str_starts_with($imagePath, 'images/')) {
                        $imagePath = 'storage' . (str_starts_with($imagePath, '/') ? $imagePath : '/' . $imagePath);
                    }
                }
                $request->user_profile_image = asset($imagePath);
            } else {
                $request->user_profile_image = null;
            }
        }

        // Process history requests
        foreach ($historyRequests as $request) {
            $customer = $request->customer;
            $averageRating = Transaction::where('customer_id', $customer->id)
                                      ->avg('rating');
            $request->average_rating = $averageRating ? number_format($averageRating, 1) : 'Not yet rated';
            $imagePath = $customer->image;
            if ($imagePath) {
                if (!str_starts_with($imagePath, 'http') && !str_starts_with($imagePath, 'storage/')) {
                    if (str_starts_with($imagePath, '/images/') || str_starts_with($imagePath, 'images/')) {
                        $imagePath = 'storage' . (str_starts_with($imagePath, '/') ? $imagePath : '/' . $imagePath);
                    }
                }
                $request->user_profile_image = asset($imagePath);
            } else {
                $request->user_profile_image = null;
            }
        }

        return response()->json([
            'active' => RequestResource::collection($activeRequests),
            'history' => RequestResource::collection($historyRequests)
        ]);
    }

    public function removeRequest($requestId)
    {
        $request = Booking::findOrFail($requestId);
        $request->removed_at = Carbon::now();
        $request->save();

        return response()->json(['message' => 'Request moved to history successfully']);
    }

    public function restoreRequest($requestId)
    {
        $request = Booking::findOrFail($requestId);
        $request->removed_at = null;
        $request->save();

        return response()->json(['message' => 'Request restored successfully']);
    }

    public function updateStatus(Request $request, $requestId)
    {
        $requestModel = Booking::findOrFail($requestId);
        $newStatus = strtoupper($request->input('status'));

        if (!in_array($newStatus, ['PENDING', 'CONFIRMED', 'CANCELLED'])) {
            return response()->json(['message' => 'Invalid status'], 400);
        }

        $requestModel->status = $newStatus;
        $requestModel->save();

        $customer = User::find($requestModel->customer_id);
        $worker = User::find($requestModel->worker_id);

        if ($newStatus === 'CANCELLED') {
            $deleteBooking = Booking::where('status', 'PENDING')
                ->where(function ($query) use ($requestModel) {
                    $query->whereBetween('start', [$requestModel->start, $requestModel->end])
                          ->orWhereBetween('end', [$requestModel->start, $requestModel->end])
                          ->orWhere(function ($query) use ($requestModel) {
                              $query->where('start', '<=', $requestModel->start)
                                    ->where('end', '>=', $requestModel->end);
                          });
                })
                ->where('worker_id', $requestModel->worker_id)
                ->where('booking_id', '!=', $requestModel->booking_id)
                ->delete();

            $this->sendBookingStatusPushNotification($requestModel, $customer, $worker, 'declined');
        } elseif ($newStatus === 'CONFIRMED') {
            $transaction = Transaction::create([
                'request_id' => Auth::id(),
                'customer_id' => $requestModel->customer_id,
                'title' => $requestModel->title,
                'name' => $customer->name,
                'description' => $requestModel->description,
                'payment_status' => "PENDING",
                'payment_date' => $requestModel->end,
                'amount' => $requestModel->amount,
            ]);

            $this->sendBookingStatusPushNotification($requestModel, $customer, $worker, 'approved');
        }

        return response()->json(['message' => ucfirst(strtolower($newStatus)) . ' successfully.']);
    }

    public function getAvailableEvents($worker_id)
    {
        $skilledworker = SkilledWorker::where('user_id', $worker_id)->first();
        $availableEvents = Booking::where('worker_id', $skilledworker->id)
            ->where('status', 'CONFIRMED')
            ->whereNull('removed_at') // Only active confirmed events
            ->get();
        return response()->json(['data' => $availableEvents]);
    }

    /**
     * Send push notification to customer about booking status change
     */
    private function sendBookingStatusPushNotification($booking, $customer, $worker, $status)
    {
        if (!$customer->device_token) {
            Log::info('Customer has no device token, skipping push notification', [
                'customer_id' => $customer->id,
                'customer_name' => $customer->name
            ]);
            return false;
        }
        
        $title = $status === 'approved' ? 'Booking Request Approved' : 'Booking Request Declined';
        $body = $status === 'approved' 
            ? 'Your booking request for "' . $booking->title . '" has been approved by ' . $worker->name 
            : 'Your booking request for "' . $booking->title . '" has been declined by ' . $worker->name;
        
        $notification = [
            'title' => $title,
            'body' => $body
        ];
        
        $data = [
            'booking_id' => $booking->booking_id,
            'worker_id' => $worker->id,
            'worker_name' => $worker->name,
            'notification_type' => 'booking_' . $status,
            'status' => $status,
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
        ];
        
        try {
            $this->firebaseService->sendNotification(
                $customer->device_token, 
                $notification, 
                $data, 
                $customer->device_type
            );
            
            Log::info('Push notification sent to customer', [
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'booking_id' => $booking->booking_id,
                'status' => $status,
                'device_type' => $customer->device_type
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send push notification to customer', [
                'error' => $e->getMessage(),
                'customer_id' => $customer->id
            ]);
            
            return false;
        }
    }
}
