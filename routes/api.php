<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\{
    UserController,
    ReportController,
    ReviewController,
    BookingController,
    MessageController,
    FavoriteController,
    WorkerWorkController,
    TransactionController,
    WorkRequestController,
    SkilledWorkerController,
    Auth\AuthController,
    ProfileController,
    ChatController,
    DeviceTokenController,
    WorkerServiceController,
    NotificationController
};



Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('user-signup', [UserController::class, 'userSignup']);
Route::post('worker-signup', [UserController::class, 'workerSignup']);
Route::get('/show-verification', [UserController::class, 'showverifications']);
Route::put('/update-verification/{id}', [UserController::class, 'updateverifications']);
Route::delete('/delete-verification/{id}', [UserController::class, 'deleteverifications']);
Route::post('/send-comment/{id}', [UserController::class, 'sendComment']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('messages', MessageController::class);
    Route::apiResource('reviews', ReviewController::class);
    Route::apiResource('skilled_workers', SkilledWorkerController::class);
    Route::get('skilled_workers/{id}', [SkilledWorkerController::class, 'show']);
    Route::apiResource('transactions', TransactionController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('worker_works', WorkerWorkController::class);
    
    // Device token routes
    Route::post('/users/device-token', [DeviceTokenController::class, 'store']);
    Route::delete('/users/device-token', [DeviceTokenController::class, 'destroy']);
    
    // Notification routes
    Route::post('/send-push-notification', [NotificationController::class, 'sendPushNotification']);
    Route::post('/client-booking-notification', [NotificationController::class, 'sendClientBookingNotification']);
    
    // Test notification route
    Route::post('/test-notification', function (Request $request, App\Services\FirebaseService $firebaseService) {
        $user = Auth::user();
        
        if (!$user || !$user->device_token) {
            return response()->json([
                'success' => false,
                'message' => 'No device token found for this user'
            ], 400);
        }
        
        $notification = [
            'title' => 'Test Notification',
            'body' => 'This is a test notification to verify FCM is working'
        ];
        
        $data = [
            'notification_type' => 'test',
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
        ];
        
        $result = $firebaseService->sendNotification(
            $user->device_token,
            $notification,
            $data,
            $user->device_type
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Test notification sent',
            'device_type' => $user->device_type,
            'result' => $result
        ]);
    });
    
    Route::post('/send-message', [ChatController::class, 'sendMessage']);
    Route::get('/get-messages/{receiverId}', [ChatController::class, 'getMessages']);
    Route::get('/conversations', [ChatController::class, 'conversations']);
    Route::get('/potential-chat-users', [ChatController::class, 'potentialChatUsers']);
    Route::post('/mark-as-read/{receiverId}', [ChatController::class, 'markAsRead']);
    Route::get('/notifications', [ChatController::class, 'getNotifications']);
    Route::post('/notifications/{notificationId}/mark-as-read', [ChatController::class, 'markNotificationAsRead']);

    Route::post('/transactions/{transactionId}/upload-qr-code', [TransactionController::class, 'uploadQrCode']);
    Route::post('/transactions/{transactionId}/upload-receipt', [TransactionController::class, 'uploadReceipt']);
    Route::post('/transactions/{transactionId}/remove-qr-code', [SkilledWorkerController::class, 'removeQrCode']);
    Route::get('/workers/{userId}/requests', [WorkRequestController::class, 'getWorkerRequests']);
    Route::get('/workers', [WorkRequestController::class, 'index']);
    Route::delete('/workers/{id}', [WorkRequestController::class, 'destroy']);
    Route::post('/postWorker', [WorkRequestController::class, 'postWorker']);
    Route::put('/requests/{requestId}', [WorkRequestController::class, 'updateStatus']);
    Route::put('/requests/{requestId}/remove', [WorkRequestController::class, 'removeRequest']);
    Route::put('/requests/{requestId}/restore', [WorkRequestController::class, 'restoreRequest']);
    Route::get('events', [BookingController::class, 'getEvents']);
    Route::put('/transactions/{transactionId}/pay', [TransactionController::class, 'payTransaction']);
    Route::post('/transactions/{transactionId}/mark-as-paid', [TransactionController::class, 'markAsPaidManually']);
    Route::get('/profile', [SkilledWorkerController::class, 'show'])->name('profile.show');
    Route::put('/update-profile', [SkilledWorkerController::class, 'update'])->name('profile.update');
    Route::post('/profile/picture', [SkilledWorkerController::class, 'updateProfilePicture'])->name('profile.updatePicture');
    Route::post('add-reviews', [ReviewController::class, 'store']);
    Route::post('/add-favorites', [FavoriteController::class, 'store']);
    Route::post('/remove-favorites', [FavoriteController::class, 'remove']);
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/add-reports', [ReportController::class, 'store']);
    Route::get('/reports', [ReportController::class, 'index']);
    Route::get('/dashboard-admin', [UserController::class, 'getdashboard']);
    Route::get('admin-profile', [UserController::class, 'getadminProfile']);
    Route::get('show-users', [UserController::class, 'showusers']);
    Route::get('show-reports', [UserController::class, 'showreports']);
    Route::put('/update-admin-profile', [UserController::class, 'updateadmin'])->name('profile.adminupdate');
    Route::post('/update-worker-picture', [SkilledWorkerController::class, 'updateworkerprofile'])->name('profile.workerupdate');
    Route::post('/change-password', [SkilledWorkerController::class, 'changePassword'])->name('password.change');
    Route::post('/get-admin-password', [UserController::class, 'getAdminPassword']);
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteuser']);
    Route::post('/update-admin-picture', [UserController::class, 'updateProfilePicture'])->name('profile.adminpicture');
    Route::get('show-verification', [UserController::class, 'showverifications']);
    Route::put('update-verification/{id}', [UserController::class, 'updateverifications']);
    Route::delete('delete-verification/{id}', [UserController::class, 'deleteverifications']);
    Route::post('/send-reports', [UserController::class, 'sendreport'])->name('send.report');
    Route::get('/getavailabledate/{worker_id}', [WorkRequestController::class, 'getAvailableEvents']);
    Route::post('/transactions/{transactionId}/submit-review', [TransactionController::class, 'submitReview']);
    Route::post('/transactions/{transactionId}/submit-review2', [TransactionController::class, 'submitReview2']);
    Route::put('/transactions/{transactionId}/success', [TransactionController::class, 'paySuccess']);
    
    // Account management routes
    Route::get('/check-account-status', [SkilledWorkerController::class, 'checkAccountStatus']);
    Route::post('/verify-password', [SkilledWorkerController::class, 'verifyPassword']);
    Route::post('/deactivate-account', [SkilledWorkerController::class, 'deactivateAccount']);
    Route::post('/reactivate-account', [SkilledWorkerController::class, 'reactivateAccount']);
    Route::post('/schedule-account-deletion', [SkilledWorkerController::class, 'scheduleAccountDeletion']);
    Route::post('/cancel-account-deletion', [SkilledWorkerController::class, 'cancelAccountDeletion']);
    
    Route::put('/requests/{requestId}', [WorkRequestController::class, 'updateStatus']);

    // Worker works route
    Route::post('/worker-works/{id}/update-with-image', [WorkerWorkController::class, 'updateWithImage']);

    // Worker schedule route
    Route::get('/workers/{workerId}/schedule', [BookingController::class, 'getWorkerSchedule']);

    // Worker availability check route
    Route::get('/workers/{workerId}/check-availability', [BookingController::class, 'checkAvailability']);

    // User bookings route
    Route::get('/user/{userId}/bookings', [BookingController::class, 'getUserBookings']);

    // New profile routes
    Route::get('/view-user-profile', [ProfileController::class, 'getUserProfile']);
    Route::put('/update-user-profile', [ProfileController::class, 'updateUserProfile']);
    Route::post('/update-profile-image', [ProfileController::class, 'updateProfileImage']);
    Route::post('/change-user-password', [ProfileController::class, 'changeUserPassword']);

    // Worker Services Routes
    Route::get('/worker-services', [WorkerServiceController::class, 'index']);
    Route::post('/worker-services', [WorkerServiceController::class, 'store']);
    Route::put('/worker-services/{id}', [WorkerServiceController::class, 'update']);
    Route::delete('/worker-services/{id}', [WorkerServiceController::class, 'destroy']);

    // New routes for verification history
    Route::get('/verification-history', [UserController::class, 'getVerificationHistory']);
    Route::delete('/delete-verification-history/{userId}', [UserController::class, 'deleteVerificationHistory']);
    Route::post('/services', [UserController::class, 'storeVerificationHistory']);
    
    // Notification routes
    Route::get('/user-notifications', [NotificationController::class, 'getUserNotifications']);
    Route::put('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);
    Route::put('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
    Route::delete('/clear-all-notifications', [NotificationController::class, 'clearAllNotifications']);

    // Online users route
    Route::get('/online-users', [ChatController::class, 'getOnlineUsers']);

    // Route for cancelling a booking
    Route::put('/bookings/{bookingId}/cancel', [BookingController::class, 'cancelBooking'])->middleware('auth:sanctum');
});

