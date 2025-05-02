<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    ChatController

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
    Route::apiResource('transactions', TransactionController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('worker_works', WorkerWorkController::class);
    
    Route::post('/send-message', [ChatController::class, 'sendMessage']);
    Route::get('/get-messages/{receiverId}', [ChatController::class, 'getMessages']);
    Route::get('/conversations', [ChatController::class, 'conversations']);
    Route::get('/potential-chat-users', [ChatController::class, 'potentialChatUsers']);
    Route::post('/mark-as-read/{receiverId}', [ChatController::class, 'markAsRead']);
    Route::get('/notifications', [ChatController::class, 'getNotifications']);
    Route::post('/notifications/{notificationId}/mark-as-read', [ChatController::class, 'markNotificationAsRead']);

    Route::post('/transactions/{transactionId}/upload-qr-code', [TransactionController::class, 'uploadQrCode']);
    Route::post('/transactions/{transactionId}/upload-receipt', [TransactionController::class, 'uploadReceipt']);
    Route::get('/workers/{userId}/requests', [WorkRequestController::class, 'getWorkerRequests']);
    Route::get('/workers', [WorkRequestController::class, 'index']);
    Route::delete('/workers/{id}', [WorkRequestController::class, 'destroy']);
    Route::post('/postWorker', [WorkRequestController::class, 'postWorker']);
    Route::put('requests/{id}', [WorkRequestController::class, 'updateStatus']);
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

    // Worker works route
    Route::post('/worker-works/{id}/update-with-image', [WorkerWorkController::class, 'updateWithImage']);

    // Worker schedule route
    Route::get('/workers/{workerId}/schedule', [BookingController::class, 'getWorkerSchedule']);

    // Worker availability check route
    Route::get('/workers/{workerId}/check-availability', [BookingController::class, 'checkAvailability']);

    // New profile routes
    Route::get('/view-user-profile', [ProfileController::class, 'getUserProfile']);
    Route::put('/update-user-profile', [ProfileController::class, 'updateUserProfile']);
    Route::post('/update-profile-image', [ProfileController::class, 'updateProfileImage']);
});

