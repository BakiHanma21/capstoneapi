<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\FirebaseService;
use App\Notifications\BookingApprovedNotification;
use App\Notifications\BookingDeclinedNotification;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }
    
    /**
     * Get all notifications for the authenticated user
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserNotifications(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // Get device identifier if provided
        $deviceId = $request->header('X-Device-ID');
        $requestType = $request->header('X-Request-Type');
        $includeAllWorkerBookings = $request->header('X-Include-All-Worker-Bookings') === 'true';
        
        Log::info('Fetching notifications for user', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'device_id' => $deviceId,
            'request_type' => $requestType,
            'include_all_worker_bookings' => $includeAllWorkerBookings
        ]);
        
        // For workers, we need to include ALL booking notifications, even read ones
        if ($user->role === 'WORKER') {
            // This ensures booking notifications are visible across all devices for workers
            Log::info('Worker notification request - including booking notifications regardless of read status', [
                'user_id' => $user->id,
                'device_id' => $deviceId,
                'include_all_worker_bookings' => $includeAllWorkerBookings
            ]);
            
            // Base query for worker notifications
            $baseQuery = DB::table('notifications')
                ->where('notifiable_id', $user->id)
                ->where('notifiable_type', 'App\\Models\\User');
                
            // First, get ALL booking notifications for workers regardless of read status
            // These are critical for worker history
            $bookingQuery = clone $baseQuery;
            $bookingNotifications = $bookingQuery
                ->where(function($query) {
                    // Convert data JSON column to check notification_type
                    $query->whereRaw("JSON_EXTRACT(data, '$.notification_type') = '\"booking_approved\"'")
                        ->orWhereRaw("JSON_EXTRACT(data, '$.notification_type') = '\"booking_declined\"'");
                })
                ->orderBy('created_at', 'desc')
                ->get();
                
            Log::info('Retrieved worker booking notifications', [
                'count' => $bookingNotifications->count(),
                'user_id' => $user->id
            ]);
            
            // Get other non-booking notifications
            $otherQuery = clone $baseQuery;
            $otherNotifications = $otherQuery
                ->where(function($query) {
                    $query->whereRaw("JSON_EXTRACT(data, '$.notification_type') != '\"booking_approved\"'")
                        ->whereRaw("JSON_EXTRACT(data, '$.notification_type') != '\"booking_declined\"'");
                })
                ->orderBy('created_at', 'desc')
                ->get();
                
            // Combine both sets of notifications
            $notifications = $bookingNotifications->concat($otherNotifications);
            
            // Re-sort by created_at
            $notifications = $notifications->sortByDesc('created_at')->values();
            
            Log::info('Combined worker notifications', [
                'booking_count' => $bookingNotifications->count(),
                'other_count' => $otherNotifications->count(),
                'total' => $notifications->count()
            ]);
        } else {
            // For regular users, just get all notifications
            $notifications = DB::table('notifications')
                ->where('notifiable_id', $user->id)
                ->where('notifiable_type', 'App\\Models\\User')
                ->orderBy('created_at', 'desc')
                ->get();
        }
            
        // Log the raw notifications for debugging
        Log::info('Raw notifications retrieved for user', [
            'user_id' => $user->id,
            'count' => $notifications->count(),
            'user_role' => $user->role,
            'device_id' => $deviceId
        ]);
            
        // Format notifications with proper emoji prefixes
        $formattedNotifications = $notifications->map(function ($notification) use ($user) {
            $data = json_decode($notification->data);
            
            // Extract notification_type from data
            $notificationType = isset($data->notification_type) ? $data->notification_type : 'general';
            
            // Add emoji prefix based on notification type
            $title = $data->title ?? '';
            if (isset($data->notification_type)) {
                if ($data->notification_type === 'new_booking_request' && !str_contains($title, '🛠')) {
                    $data->title = '🛠 ' . $title;
                } else if ($data->notification_type === 'booking_approved' && !str_contains($title, '✅')) {
                    $data->title = '✅ ' . $title;
                } else if ($data->notification_type === 'booking_declined' && !str_contains($title, '❌')) {
                    $data->title = '❌ ' . $title;
                }
            }
            
            // Use the timestamp from the notification data if available, otherwise use created_at
            $timestamp = isset($data->timestamp) ? $data->timestamp : $notification->created_at;
            
            // Determine if this is a worker booking notification that should be preserved
            $isWorkerBookingNotification = 
                $user->role === 'WORKER' && 
                in_array($notificationType, ['booking_approved', 'booking_declined']);
                
            // Mark persistent flag for worker booking notifications
            $isPersistent = $isWorkerBookingNotification;
            
            // Log individual notification for debugging
            Log::debug('Processing notification', [
                'id' => $notification->id,
                'type' => $notificationType,
                'read' => $notification->read_at !== null,
                'timestamp' => $timestamp,
                'is_worker_booking' => $isWorkerBookingNotification,
                'persistent' => $isPersistent,
                'user_id' => $user->id
            ]);
            
            // For worker booking notifications, enhance the data for client display
            if ($isWorkerBookingNotification) {
                // Add explicit flags for the frontend to handle these notifications specially
                if (!isset($data->for_worker)) {
                    $data->for_worker = true;
                }
                
                if (!isset($data->persist_for_worker)) {
                    $data->persist_for_worker = true;
                }
                
                // Add user ID to ensure it's only shown to the correct worker
                if (!isset($data->worker_id)) {
                    $data->worker_id = $user->id;
                }
                
                Log::info('Enhanced worker booking notification for display', [
                    'notification_id' => $notification->id,
                    'type' => $notificationType,
                    'worker_id' => $user->id
                ]);
            }
            
            return [
                'id' => $notification->id,
                'title' => $data->title ?? 'Notification',
                'body' => $data->body ?? '',
                'type' => $notificationType,
                'read' => $notification->read_at !== null,
                'timestamp' => $timestamp,
                'data' => $data,
                'persistent' => $isPersistent,
                'for_worker' => $isWorkerBookingNotification,
                'user_id' => $user->id // Always include user ID for filtering
            ];
        });
        
        // For workers, ensure booking-related notifications are included even if marked as read
        if ($user->role === 'WORKER') {
            // Filter notifications to find booking-related ones
            $bookingNotifications = $formattedNotifications->filter(function ($notification) {
                return in_array($notification['type'], ['booking_approved', 'booking_declined']);
            });
            
            // Count booking notifications for logging
            $bookingApprovedCount = $bookingNotifications->filter(function ($notification) {
                return $notification['type'] === 'booking_approved';
            })->count();
            
            $bookingDeclinedCount = $bookingNotifications->filter(function ($notification) {
                return $notification['type'] === 'booking_declined';
            })->count();
            
            Log::info('Worker booking notifications count', [
                'user_id' => $user->id,
                'approved_count' => $bookingApprovedCount,
                'declined_count' => $bookingDeclinedCount,
                'total_booking' => $bookingNotifications->count()
            ]);
        }
        
        // Group notifications by type for debugging
        $notificationsByType = [];
        foreach ($formattedNotifications as $notification) {
            $type = $notification['type'];
            if (!isset($notificationsByType[$type])) {
                $notificationsByType[$type] = 0;
            }
            $notificationsByType[$type]++;
        }
        
        // Count worker booking notifications specifically
        $workerBookingCount = 0;
        if ($user->role === 'WORKER') {
            $workerBookingCount = $formattedNotifications->filter(function ($notification) {
                return $notification['persistent'] === true;
            })->count();
        }
        
        Log::info('Returning notifications for user by type', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'count' => $formattedNotifications->count(),
            'types' => $notificationsByType,
            'worker_booking_count' => $workerBookingCount,
            'device_id' => $deviceId
        ]);
        
        return response()->json([
            'notifications' => $formattedNotifications
        ]);
    }
    
    /**
     * Send push notification to a specific user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendPushNotification(Request $request)
    {
        try {
            // Log the entire request for debugging
            Log::info('Push notification request received', [
                'data' => $request->all(),
                'content_type' => $request->header('Content-Type'),
                'headers' => $request->headers->all()
            ]);
            
            // First, try to find the user ID from various possible field names
            $userId = null;
            $possibleFields = ['user_id', 'userId', 'customer_id', 'client_id', 'recipient_id', 'id'];
            
            foreach ($possibleFields as $field) {
                if ($request->has($field) && !empty($request->$field)) {
                    $userId = $request->$field;
                    Log::info("Found user ID in field: {$field}", ['value' => $userId]);
                    break;
                }
            }
            
            // If no user ID found in standard fields, check if it's nested in data
            if (!$userId && $request->has('data')) {
                $data = $request->data;
                if (is_array($data) || is_object($data)) {
                    foreach ($possibleFields as $field) {
                        if (isset($data[$field]) && !empty($data[$field])) {
                            $userId = $data[$field];
                            Log::info("Found user ID in data.{$field}", ['value' => $userId]);
                            break;
                        }
                    }
                }
            }
            
            // If still no user ID found, check if it's in the JSON body
            if (!$userId && $request->getContent()) {
                $jsonData = json_decode($request->getContent(), true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($jsonData)) {
                    Log::info("Checking JSON body for user ID", ['json_data' => $jsonData]);
                    foreach ($possibleFields as $field) {
                        if (isset($jsonData[$field]) && !empty($jsonData[$field])) {
                            $userId = $jsonData[$field];
                            Log::info("Found user ID in JSON body field: {$field}", ['value' => $userId]);
                            break;
                        }
                    }
                }
            }
            
            // If no user ID found, return error
            if (!$userId) {
                Log::error('User ID not found in request', [
                    'fields_checked' => $possibleFields,
                    'request_data' => $request->all(),
                    'json_body' => $request->getContent()
                ]);
                return response()->json(['error' => 'The user id field is required'], 422);
            }
            
            // Validate other required fields
            $validated = $request->validate([
                'title' => 'required',
                'body' => 'required',
                'notification_type' => 'required|in:new_booking_request,booking_approved,booking_declined,new_message,payment_received,payment_sent',
                'data' => 'sometimes|array'
            ]);
            
            Log::info('Validation passed', ['validated' => $validated, 'user_id' => $userId]);
            
            // Find the recipient user by ID
            $recipient = User::find($userId);
            
            if (!$recipient) {
                Log::error('Recipient user not found', [
                    'user_id' => $userId,
                    'all_request_data' => $request->all()
                ]);
                
                // Try to find the user by other means as a fallback
                if ($request->has('name')) {
                    Log::info('Trying to find user by name', ['name' => $request->name]);
                    $recipientByName = User::where('name', $request->name)->first();
                    if ($recipientByName) {
                        Log::info('Found user by name instead of ID', [
                            'name' => $request->name,
                            'found_id' => $recipientByName->id
                        ]);
                        $recipient = $recipientByName;
                    }
                }
                
                // If still not found, return error
                if (!$recipient) {
                    return response()->json([
                        'error' => 'Recipient user not found',
                        'user_id_tried' => $userId
                    ], 404);
                }
            }
            
            Log::info('Recipient found', ['user' => $recipient->id, 'name' => $recipient->name]);
            
            // Check if the user has a device token
            if (!$recipient->device_token) {
                Log::info('User has no device token', ['user_id' => $recipient->id]);
                
                // Create notification object
                $notification = new \stdClass();
                $notification->title = $request->title;
                $notification->body = $request->body;
                $notification->notification_type = $request->notification_type;
                $notification->data = $request->data ?? [];
                
                // Store notification
                $recipient->notify(new \App\Notifications\GenericNotification($notification));
                
                return response()->json([
                    'success' => true,
                    'message' => 'Notification stored in database, but no device token available'
                ]);
            }
            
            // Prepare notification payload
            $notificationPayload = [
                'title' => $request->title,
                'body' => $request->body,
            ];
            
            // Prepare data payload
            $dataPayload = [
                'notification_type' => $request->notification_type,
                'title' => $request->title,
                'body' => $request->body,
            ];
            
            // Add custom data from the request if available
            if ($request->has('data')) {
                $dataPayload = array_merge($dataPayload, $request->data);
            }
            
            // Send push notification
            $result = $this->firebaseService->sendNotification(
                $recipient->device_token,
                $notificationPayload,
                $dataPayload,
                $recipient->device_type
            );
            
            // Also store in database for notification bell
            $notification = new \stdClass();
            $notification->title = $request->title;
            $notification->body = $request->body;
            $notification->notification_type = $request->notification_type;
            $notification->data = $dataPayload;
            
            // Store notification
            $recipient->notify(new \App\Notifications\GenericNotification($notification));
            
            Log::info('Push notification sent', [
                'recipient' => $recipient->id,
                'notification' => $notificationPayload,
                'data' => $dataPayload,
                'result' => $result
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Push notification sent',
                'result' => $result
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error sending push notification', [
                'errors' => $e->errors()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error sending push notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Mark a notification as read
     * 
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // Log the request details for debugging
        Log::info('Mark notification as read request received', [
            'user_id' => $user->id,
            'notification_id' => $id,
            'user_role' => $user->role,
            'request_data' => $request->all()
        ]);
        
        // Validate UUID format to avoid database errors
        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $id)) {
            Log::warning('Invalid notification ID format', [
                'user_id' => $user->id,
                'notification_id' => $id
            ]);
            
            return response()->json([
                'error' => 'Invalid notification ID format',
                'message' => 'The notification ID must be a valid UUID',
                'valid_locally' => true
            ], 422);
        }
        
        // Check if the notification exists
        $notification = DB::table('notifications')
            ->where('id', $id)
            ->where('notifiable_id', $user->id)
            ->first();
            
        if (!$notification) {
            Log::warning('Notification not found for user', [
                'user_id' => $user->id,
                'notification_id' => $id
            ]);
            
            return response()->json([
                'error' => 'Notification not found',
                'message' => 'The specified notification does not exist or does not belong to this user',
                'valid_locally' => true
            ], 404);
        }
        
        // Check if this is a notification that should be preserved (for worker booking notifications)
        $shouldPreserve = $request->has('preserve_notification') && $request->preserve_notification === true;
        $notificationData = json_decode($notification->data);
        $notificationType = isset($notificationData->notification_type) ? $notificationData->notification_type : null;
        
        // Log the preservation request
        Log::info('Marking notification as read with preservation check', [
            'notification_id' => $id,
            'should_preserve' => $shouldPreserve,
            'notification_type' => $notificationType,
            'user_role' => $user->role
        ]);
        
        // Only mark as read, but keep the notification for workers with booking notifications
        $isWorkerBookingNotification = 
            $user->role === 'WORKER' && 
            in_array($notificationType, ['booking_approved', 'booking_declined']) &&
            $shouldPreserve;
            
        if ($isWorkerBookingNotification) {
            // For worker booking notifications, only update read_at without deleting
            Log::info('Preserving worker booking notification while marking as read', [
                'notification_id' => $id,
                'type' => $notificationType
            ]);
        
        DB::table('notifications')
            ->where('id', $id)
            ->update(['read_at' => now()]);
            
            return response()->json([
                'message' => 'Notification marked as read and preserved',
                'preserved' => true,
                'notification_id' => $id,
                'notification_type' => $notificationType
            ]);
        } else {
            // Standard behavior for other notifications
        DB::table('notifications')
            ->where('id', $id)
            ->update(['read_at' => now()]);
            
            return response()->json([
                'message' => 'Notification marked as read',
                'notification_id' => $id,
                'notification_type' => $notificationType
            ]);
        }
    }
    
    /**
     * Mark all notifications as read
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // For workers, preserve booking notifications when marking all as read
        if ($user->role === 'WORKER') {
            Log::info('Worker marking all notifications as read - preserving booking notifications', [
                'user_id' => $user->id
            ]);
            
            // First, get all notifications
            $notifications = DB::table('notifications')
                ->where('notifiable_id', $user->id)
                ->whereNull('read_at')
                ->get();
                
            // Track which ones are booking related
            $nonBookingNotificationIds = [];
            $bookingNotificationIds = [];
            
            foreach ($notifications as $notification) {
                $data = json_decode($notification->data);
                $notificationType = isset($data->notification_type) ? $data->notification_type : null;
                
                if (in_array($notificationType, ['booking_approved', 'booking_declined'])) {
                    $bookingNotificationIds[] = $notification->id;
                } else {
                    $nonBookingNotificationIds[] = $notification->id;
                }
            }
            
            // Mark all notifications as read, including booking notifications
            DB::table('notifications')
                ->where('notifiable_id', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
                
            Log::info('Worker notifications marked as read with preservation', [
                'user_id' => $user->id,
                'total_notifications' => count($notifications),
                'booking_notifications_preserved' => count($bookingNotificationIds),
                'non_booking_notifications' => count($nonBookingNotificationIds)
            ]);
            
            return response()->json([
                'message' => 'All notifications marked as read, booking notifications preserved',
                'preserved_count' => count($bookingNotificationIds)
            ]);
        }
        
        // For regular users, mark all as read without preservation
        DB::table('notifications')
            ->where('notifiable_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            
        return response()->json(['message' => 'All notifications marked as read']);
    }
    
    /**
     * Clear all notifications for the authenticated user
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearAllNotifications(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // Get headers and body information
        $includeBookingNotifications = $request->header('X-Include-Booking-Notifications') === 'true';
        $userRole = $request->header('X-User-Role');
        $deviceId = $request->header('X-Device-ID');
        
        // Check request body for clear_booking_notifications flag
        $clearBookingNotifications = $request->has('clear_booking_notifications') && 
                                     $request->clear_booking_notifications === true;
        
        // For workers, we need special handling to preserve booking notifications
        if ($user->role === 'WORKER') {
            Log::info('Worker attempting to clear notifications', [
                'user_id' => $user->id,
                'device_id' => $deviceId,
                'include_booking_notifications' => $includeBookingNotifications,
                'clear_booking_notifications' => $clearBookingNotifications
            ]);
            
            // By default, preserve booking notifications unless explicitly told to clear them
            if (!$clearBookingNotifications && !$includeBookingNotifications) {
                // First, identify booking notifications - these will be preserved
                // Get all notifications for the worker
                $allNotifications = \App\Models\Notification::where('notifiable_id', $user->id)
                    ->where('notifiable_type', 'App\\Models\\User')
                    ->get();
                    
                $bookingNotificationIds = [];
                $nonBookingNotificationIds = [];
                
                foreach ($allNotifications as $notification) {
                    // Extract notification type from data
                    $data = json_decode($notification->data, true);
                    $notificationType = $data['notification_type'] ?? null;
                    
                    // Check if this is a booking notification
                    if (in_array($notificationType, ['booking_approved', 'booking_declined'])) {
                        $bookingNotificationIds[] = $notification->id;
                    } else {
                        $nonBookingNotificationIds[] = $notification->id;
                    }
                }
                
                // Only delete non-booking notifications
                if (count($nonBookingNotificationIds) > 0) {
                    DB::table('notifications')
                        ->whereIn('id', $nonBookingNotificationIds)
                        ->delete();
                }
                
                Log::info('Worker notifications selectively cleared, preserving booking notifications', [
                    'user_id' => $user->id,
                    'booking_notifications_preserved' => count($bookingNotificationIds),
                    'other_notifications_cleared' => count($nonBookingNotificationIds)
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Non-booking notifications cleared, booking notifications preserved',
                    'count_cleared' => count($nonBookingNotificationIds),
                    'count_preserved' => count($bookingNotificationIds)
                ]);
            }
            
            // If explicitly confirmed, delete all notifications including booking ones
            Log::info('Worker requested to clear ALL notifications including booking ones', [
                'user_id' => $user->id,
                'explicit_confirmation' => true
            ]);
        }
        
        // Get all notification IDs for the user
        $notificationIds = DB::table('notifications')
            ->where('notifiable_id', $user->id)
            ->pluck('id');
            
        // Log action for debugging
        Log::info('Clearing all notifications for user', [
            'user_id' => $user->id,
            'notification_count' => count($notificationIds)
        ]);
        
        // Delete all notifications for the user
        DB::table('notifications')
            ->where('notifiable_id', $user->id)
            ->delete();
            
        return response()->json([
            'success' => true,
            'message' => 'All notifications cleared',
            'count_cleared' => count($notificationIds)
        ]);
    }
    
    /**
     * Send a booking notification to a client
     * This is a specialized endpoint for worker-to-client notifications about bookings
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendClientBookingNotification(Request $request)
    {
        try {
            // Log the entire request for debugging
            Log::info('Client booking notification request received', [
                'data' => $request->all()
            ]);
            
            // Validate required fields
            $validated = $request->validate([
                'client_name' => 'required|string',
                'booking_id' => 'required',
                'notification_type' => 'required|in:booking_approved,booking_declined',
                'title' => 'required|string',
                'body' => 'required|string',
                'worker_id' => 'required',
                'worker_name' => 'required|string'
            ]);
            
            // Try to find the client by name
            $client = User::where('name', $request->client_name)->first();
            
            if (!$client) {
                Log::error('Client not found by name', [
                    'client_name' => $request->client_name
                ]);
                return response()->json([
                    'error' => 'Client not found by name',
                    'client_name' => $request->client_name
                ], 404);
            }
            
            Log::info('Client found', [
                'client_id' => $client->id,
                'client_name' => $client->name
            ]);
            
            // Create notification object
            $notification = new \stdClass();
            $notification->title = $request->title;
            $notification->body = $request->body;
            $notification->notification_type = $request->notification_type;
            $notification->worker_name = $request->worker_name;
            $notification->data = [
                'booking_id' => $request->booking_id,
                'worker_id' => $request->worker_id,
                'worker_name' => $request->worker_name
            ];
            
            // Include timestamp if provided or generate a new one
            $timestamp = null;
            if ($request->has('timestamp')) {
                $timestamp = $request->timestamp;
                Log::info('Using provided timestamp', ['timestamp' => $timestamp]);
            } else {
                $timestamp = now()->toIso8601String();
                Log::info('Using server timestamp', ['timestamp' => $timestamp]);
            }
            $notification->timestamp = $timestamp;
            
            // Store notification in database
            $client->notify(new \App\Notifications\GenericNotification($notification));
            
            // If client has a device token, send push notification
            if ($client->device_token) {
                $notificationPayload = [
                    'title' => $request->title,
                    'body' => $request->body
                ];
                
                $dataPayload = [
                    'notification_type' => $request->notification_type,
                    'title' => $request->title,
                    'body' => $request->body,
                    'booking_id' => $request->booking_id,
                    'worker_id' => $request->worker_id,
                    'worker_name' => $request->worker_name,
                    'timestamp' => $timestamp
                ];
                
                $result = $this->firebaseService->sendNotification(
                    $client->device_token,
                    $notificationPayload,
                    $dataPayload,
                    $client->device_type
                );
                
                Log::info('Push notification sent to client', [
                    'client_id' => $client->id,
                    'result' => $result
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Push notification sent to client',
                    'result' => $result
                ]);
            } else {
                Log::info('Client has no device token, notification stored in database only', [
                    'client_id' => $client->id
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Notification stored in database, but client has no device token'
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error sending client booking notification', [
                'errors' => $e->errors()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error sending client booking notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Send a booking approval notification to a client
     *
     * @param Request $request
     * @param int $bookingId
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendBookingApprovalNotification(Request $request, $bookingId)
    {
        try {
            // Log the request
            Log::info('Booking approval notification request received', [
                'booking_id' => $bookingId,
                'data' => $request->all()
            ]);
            
            // Get the booking
            $booking = \App\Models\Booking::find($bookingId);
            
            if (!$booking) {
                Log::error('Booking not found', ['booking_id' => $bookingId]);
                return response()->json(['error' => 'Booking not found'], 404);
            }
            
            // Get the client
            $client = \App\Models\User::find($booking->user_id);
            
            if (!$client) {
                Log::error('Client not found', ['user_id' => $booking->user_id]);
                return response()->json(['error' => 'Client not found'], 404);
            }
            
            // Get the worker
            $worker = \App\Models\User::find($booking->worker_id);
            
            if (!$worker) {
                Log::error('Worker not found', ['worker_id' => $booking->worker_id]);
                return response()->json(['error' => 'Worker not found'], 404);
            }
            
            // Create notification object
            $notification = new \stdClass();
            $notification->title = "✅ Booking Approved: {$booking->title}";
            $notification->body = "Your booking request for {$booking->title} has been approved by {$worker->name}.";
            $notification->notification_type = 'booking_approved';
            $notification->worker_name = $worker->name;
            $notification->timestamp = now()->toIso8601String(); // Add explicit timestamp
            $notification->data = [
                'booking_id' => $bookingId,
                'worker_id' => $worker->id,
                'worker_name' => $worker->name
            ];
            
            // Store notification in database
            $client->notify(new \App\Notifications\GenericNotification($notification));
            
            // If client has a device token, send push notification
            if ($client->device_token) {
                $notificationPayload = [
                    'title' => $notification->title,
                    'body' => $notification->body
                ];
                
                $dataPayload = [
                    'notification_type' => $notification->notification_type,
                    'title' => $notification->title,
                    'body' => $notification->body,
                    'booking_id' => $bookingId,
                    'worker_id' => $worker->id,
                    'worker_name' => $worker->name,
                    'timestamp' => $notification->timestamp
                ];
                
                $result = $this->firebaseService->sendNotification(
                    $client->device_token,
                    $notificationPayload,
                    $dataPayload,
                    $client->device_type
                );
                
                Log::info('Push notification sent to client', [
                    'client_id' => $client->id,
                    'result' => $result
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Push notification sent to client',
                    'result' => $result
                ]);
            } else {
                Log::info('Client has no device token, notification stored in database only', [
                    'client_id' => $client->id
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Notification stored in database, but client has no device token'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error sending booking approval notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Send a booking decline notification to a client
     *
     * @param Request $request
     * @param int $bookingId
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendBookingDeclineNotification(Request $request, $bookingId)
    {
        try {
            // Log the request
            Log::info('Booking decline notification request received', [
                'booking_id' => $bookingId,
                'data' => $request->all()
            ]);
            
            // Get the booking
            $booking = \App\Models\Booking::find($bookingId);
            
            if (!$booking) {
                Log::error('Booking not found', ['booking_id' => $bookingId]);
                return response()->json(['error' => 'Booking not found'], 404);
            }
            
            // Get the client
            $client = \App\Models\User::find($booking->user_id);
            
            if (!$client) {
                Log::error('Client not found', ['user_id' => $booking->user_id]);
                return response()->json(['error' => 'Client not found'], 404);
            }
            
            // Get the worker
            $worker = \App\Models\User::find($booking->worker_id);
            
            if (!$worker) {
                Log::error('Worker not found', ['worker_id' => $booking->worker_id]);
                return response()->json(['error' => 'Worker not found'], 404);
            }
            
            // Create notification object
            $notification = new \stdClass();
            $notification->title = "❌ Booking Declined: {$booking->title}";
            $notification->body = "Your booking request for {$booking->title} has been declined by {$worker->name}.";
            $notification->notification_type = 'booking_declined';
            $notification->worker_name = $worker->name;
            $notification->timestamp = now()->toIso8601String(); // Add explicit timestamp
            $notification->data = [
                'booking_id' => $bookingId,
                'worker_id' => $worker->id,
                'worker_name' => $worker->name
            ];
            
            // Store notification in database
            $client->notify(new \App\Notifications\GenericNotification($notification));
            
            // If client has a device token, send push notification
            if ($client->device_token) {
                $notificationPayload = [
                    'title' => $notification->title,
                    'body' => $notification->body
                ];
                
                $dataPayload = [
                    'notification_type' => $notification->notification_type,
                    'title' => $notification->title,
                    'body' => $notification->body,
                    'booking_id' => $bookingId,
                    'worker_id' => $worker->id,
                    'worker_name' => $worker->name,
                    'timestamp' => $notification->timestamp
                ];
                
                $result = $this->firebaseService->sendNotification(
                    $client->device_token,
                    $notificationPayload,
                    $dataPayload,
                    $client->device_type
                );
                
                Log::info('Push notification sent to client', [
                    'client_id' => $client->id,
                    'result' => $result
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Push notification sent to client',
                    'result' => $result
                ]);
            } else {
                Log::info('Client has no device token, notification stored in database only', [
                    'client_id' => $client->id
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Notification stored in database, but client has no device token'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error sending booking decline notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
