<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\SkilledWorker;
use App\Models\WorkerWork;
use App\Models\VerificationHistory;
use App\Models\WorkRequest;
use App\Models\Transaction;
use App\Models\Report;
use App\Models\Favorite;
use App\Models\Review;
use App\Models\Booking;
use App\Mail\AccountDisabled;
use App\Mail\AccountEnabled;
use App\Mail\AccountApproved;
use App\Mail\AccountDenied;
use App\Mail\CommentSent;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * @group User API
     * 
     * Get All User
     */
    public function index(Request $request)
    {
        $users = User::paginate();

        return UserResource::collection($users);
    }

    /**
     * @group User API
     * 
     * Store User
     */
    public function store(UserRequest $request): User
    {
        return User::create($request->validated());
    }

    public function showusers()
    {
        $users = User::where('role', 'USER')->where('availability', '!=', 5)->get();
        $workers = User::where('role', 'WORKER')->where('availability', '!=', 5)->get();
        
        return response()->json([
            'users' => $users,
            'workers' => $workers,
        ]);
        
    }

    public function showreports()
    {
        $reports = Report::all();
        return response()->json($reports);
    }

    public function updateverifications(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Save to verification history before updating
        $this->storeVerificationHistory($user, 'Approved');

        $user->availability = 0;
        $user->save();

        if ($request->has('sendEmail') && $request->sendEmail && $request->emailType === 'approval') {
            Mail::to($user->email)->send(new AccountApproved($user));
        }

        $users = User::where('availability', 5)->get();

        $usersWithUrls = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'contactNumber' => $user->phone,
                'experience' => $user->experience,
                'skills' => $user->skills,
                'role' => $user->role,
                'location' => $user->location,
                'purok' => $user->purok,
                'street' => $user->street,
                'image' => $user->image ? url(Storage::url($user->image)) : null,
                'valid_id' => $user->valid_id ? url(Storage::url($user->valid_id)) : null,
            ];
        });

        return response()->json($usersWithUrls);
    }

    public function deleteverifications(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Save to verification history before deleting
        $this->storeVerificationHistory($user, 'Denied');
        
        if ($request->has('sendEmail') && $request->sendEmail && $request->emailType === 'denial') {
            // Get the denial reason from the request
            $denialReason = $request->input('denialReason');
            Mail::to($user->email)->send(new AccountDenied($user, $denialReason));
        }
        
        if ($user->role === 'WORKER') {
            $skilled = SkilledWorker::where('user_id', $user->id)->first();
            if ($skilled) {
                WorkerWork::where('worker_id', $skilled->id)->delete();
                $skilled->delete();
            }
        }
        
        $user->delete();

        $users = User::where('availability', 5)->get();

        $usersWithUrls = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'contactNumber' => $user->phone,
                'experience' => $user->experience,
                'skills' => $user->skills,
                'role' => $user->role,
                'location' => $user->location,
                'purok' => $user->purok,
                'street' => $user->street,
                'image' => $user->image ? url(Storage::url($user->image)) : null,
                'valid_id' => $user->valid_id ? url(Storage::url($user->valid_id)) : null,
            ];
        });

        return response()->json($usersWithUrls);
    }
    

    
    public function showverifications()
{
    $users = User::where('availability', 5)->get();

    $usersWithUrls = $users->map(function ($user) {
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'contactNumber' => $user->phone,
            'experience' => $user->experience,
            'skills' => $user->skills,
            'role' => $user->role,
            'location' => $user->location,
            'purok' => $user->purok,
            'street' => $user->street,
            'image' => $user->image ? url(Storage::url($user->image)) : null,
            'valid_id' => $user->valid_id ? url(Storage::url($user->valid_id)) : null,
        ];
        
        // Add work examples for workers
        if ($user->role === 'WORKER') {
            $skilled = SkilledWorker::where('user_id', $user->id)->first();
            if ($skilled) {
                $workExamples = WorkerWork::where('worker_id', $skilled->id)->get();
                $data['work_examples'] = $workExamples->map(function ($work) {
                    return [
                        'title' => $work->title,
                        'description' => $work->description,
                        'image' => $work->image ? url(Storage::url($work->image)) : null
                    ];
                });
            }
        }
        
        return $data;
    });

    return response()->json($usersWithUrls);
}

    public function sendComment(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'comment' => 'required|string',
        ]);
        
        Mail::to($user->email)->send(new CommentSent($user, $request->comment));
        
        return response()->json(['message' => 'Comment sent successfully'], 200);
    }

    public function deleteuser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $reasonMap = [
            'Unpaid Fees' => 'Unpaid Fees: User did not pay the required fees within the grace period.',
            'Misuse of Booking Features' => 'Misuse of Booking Features: User repeatedly booked services without intent to use them, blocking availability for others.',
            'Incomplete Work' => 'Incomplete Work: User failed to provide work for the worker as stated in the booking.',
            'Temporary Disablement' => 'Temporary Disablement: User account disabled due to reports or suspected policy violations. Investigation ongoing.',
            'Service Quality Complaints' => 'Service Quality Complaints: Multiple reports regarding poor service quality or non-delivery of services.',
            'False Claims' => 'False Claims: User submitted false or misleading service requests or complaints.',
        ];

        if ($user->availability == 4) {
            $user->availability = 0;
            $user->report_reason = null;
            $user->save();

            Mail::to($user->email)->send(new AccountEnabled($user));
        }
        else {
            
            $request->validate([
                'reason' => 'required|string|in:' . implode(',', array_keys($reasonMap)),
            ]);

            $reason = $reasonMap[$request->reason];
            Mail::to($user->email)->send(new AccountDisabled($user, $reason));
            $user->report_reason = $request->reason;
            $user->availability = 4;
            $user->save();
        }

        $users = User::where('role', 'USER')->where('availability', '!=', 5)->get();
        $workers = User::where('role', 'WORKER')->where('availability', '!=', 5)->get();

        return response()->json([
            'users' => $users,
            'workers' => $workers,
        ]);
    }

    
    /**
     * @group User API
     * 
     * Show User
     */
    public function show(User $user): User
    {
        return $user;
    }

     /**
     * @group User API
     * 
     * Update User
     */
    public function update(UserRequest $request, User $user): User
    {
        $user->update($request->validated());

        return $user;
    }

    /**
     * @group User API
     * 
     * Delete User
     */
    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }

    public function getdashboard(Request $request) {
        // Check if we should only count verified users
        $verifiedOnly = $request->has('verified_only') && $request->verified_only === 'true';
        
        // Build queries based on the verified_only parameter
        $userQuery = User::where('role', 'USER');
        $workerQuery = User::where('role', 'WORKER');
        
        // If verified_only is true, only count users with availability != 5
        if ($verifiedOnly) {
            $userQuery->where('availability', '!=', 5);
            $workerQuery->where('availability', '!=', 5);
        }
        
        $totalUsers = $userQuery->count(); 
        $totalSkilledWorkers = $workerQuery->count(); 

        // Return data in JSON format
        return response()->json([
            'totalUsers' => $totalUsers,
            'totalSkilledWorkers' => $totalSkilledWorkers
        ]);
    }

    public function getadminProfile()
    {
        $user = User::find(Auth::id());
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'image' => $user->image ? url('storage/' . $user->image) : null,
            'role' => $user->role,
            'created_at' => $user->created_at,
            'last_login' => $user->updated_at
        ]);
    }

    public function updateadmin(Request $request)
    {
        $user = User::find(Auth::id());
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'currentPassword' => 'required|string',
        ]);

        // Verify current password
        if (!Hash::check($request->currentPassword, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = 'ADMINISTRATOR'; // Always set to ADMINISTRATOR
        
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'created_at' => $user->created_at,
                'last_login' => $user->updated_at
            ]
        ]);
    }

    public function updateProfilePicture(Request $request)
{
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('profile_picture')) {
    $file = $request->file('profile_picture');
    $imageName = time() . '.' . $file->extension();
    $file->move(public_path('storage/images'), $imageName);

        $user = User::find(Auth::id());
    $user->image = "images/" . $imageName;
    $user->save();

    return response()->json([
            'message' => 'Profile picture updated successfully',
            'image_url' => url('storage/images/' . $imageName)
        ]);
    }

    return response()->json([
        'message' => 'No image file provided'
    ], 400);
}




public function userSignup(Request $request)
{
    try {
        Log::info('UserSignup request received.', ['data' => $request->all()]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'profile_picture' => 'nullable|image|max:2048',
            'phone_number' => 'required|regex:/^[0-9]{11}$/',
            'purok' => 'required|string|max:255',
            'street' => 'required|string|max:255',
        ]);

        Log::info('Validation passed.');

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = "USER";
        $user->phone = $request->phone_number;
        $user->availability = 5;
        $user->purok = $request->purok;     // Store district/purok
        $user->street = $request->street;   // Store street
        // Combining purok and street for the location field for backward compatibility
        $user->location = $request->purok . ', ' . $request->street;

        if ($request->hasFile('profile_picture')) {
            Log::info('Profile picture found.');

            $file = $request->file('profile_picture');
            $imageName = time() . '.' . $file->extension();
            $file->move(public_path('storage/images'), $imageName);
            $user->image = "images/" . $imageName;

            Log::info('Image saved: ' . $user->image);
        }

        $user->save();
        Log::info('User saved successfully.');

        return response()->json(['message' => 'User registered successfully!'], 201);
    } catch (\Exception $e) {
        Log::error('Error in userSignup: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while processing your request.'], 500);
    }
}


public function workerSignup(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'profile_picture' => 'nullable|image|max:2048',
        'phoneNumber' => 'required|regex:/^[0-9]{11}$/',
        'location' => 'required|string|max:255',
        'skills' => 'required|string|max:255',
        'valid_id' => 'nullable|image|max:2048',
        'years_of_experience' => 'required|integer|min:0',
        'work_example_1_title' => 'required|string|max:255',
        'work_example_1_description' => 'required|string',
        'work_example_1_image' => 'required|image|max:2048',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->role = "WORKER";
    $user->phone = $request->phoneNumber;
    $user->availability = 5;

    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $imageName = time() . '_profile.' . $file->extension();
        $file->move(public_path('storage/images'), $imageName);
        $user->image = "images/" . $imageName;
    }

    $user->location = $request->location;
    $user->skills = $request->skills;
    $user->experience = $request->years_of_experience;
    $user->job = null;
    $user->email_verified_at = null;
    $user->profile_image = null;
    $user->occupation = null;
    $user->certifications = null;
    $user->purok = null;
    $user->street = null;
    $user->rating = null;
    $user->reviews = null;

    if ($request->hasFile('valid_id')) {
        $file = $request->file('valid_id');
        $imageName = time() . '_valid_id.' . $file->extension();
        $file->move(public_path('storage/images'), $imageName);
        $user->valid_id = "images/" . $imageName;
    }

    $user->save();

    $skilledWorker = new SkilledWorker();
    $skilledWorker->user_id = $user->id;
    $skilledWorker->location = $request->location;
    $skilledWorker->job = $request->skills;
    $skilledWorker->experience = $request->years_of_experience;
    $skilledWorker->availability = 0;
    $skilledWorker->save();

    // Process only one work example instead of two
    $workExampleTitle = $request->input("work_example_1_title");
    $workExampleDescription = $request->input("work_example_1_description");
    $workExampleImage = null;

    if ($request->hasFile("work_example_1_image")) {
        $file = $request->file("work_example_1_image");
        $imageName = time() . '_work_example_1.' . $file->extension();
        $file->move(public_path('storage/images'), $imageName);
        $workExampleImage = "images/" . $imageName;
    }
    
    WorkerWork::create([
        'worker_id' => $skilledWorker->id,
        'title' => $workExampleTitle,
        'description' => $workExampleDescription,
        'image' => $workExampleImage,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['message' => 'User and worker profile registered successfully!']);
}
    public function sendreport(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string|min:6',
            'reported_person' => 'required|string'
        ]);

        $email = $request->email;
        $message = $request->message;
        $reportedPerson = $request->reported_person;

        try {
            Mail::send([], [], function ($mail) use ($email, $message, $reportedPerson) {
                $mail->to($email)
                    ->subject("Report regarding $reportedPerson")
                    ->setBody("<p>$message</p>", 'text/html');
            });

            return response()->json(['message' => 'Report sent successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send the report.'], 500);
        }

    }

    public function storeVerificationHistory($user, $status)
    {
        $workExamples = [];
        if ($user->role === 'WORKER') {
            $skilled = SkilledWorker::where('user_id', $user->id)->first();
            if ($skilled) {
                // Get all work examples for this worker (could be 1-3 examples)
                $workExamples = WorkerWork::where('worker_id', $skilled->id)->get()->map(function ($work) {
                    return [
                        'title' => $work->title,
                        'description' => $work->description,
                        'image' => $work->image ? url(Storage::url($work->image)) : null,
                    ];
                })->toArray();
            }
        }

        VerificationHistory::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'experience' => $user->experience,
            'skills' => $user->skills,
            'role' => $user->role,
            'location' => $user->location,
            'purok' => $user->purok,
            'street' => $user->street,
            'image' => $user->image ? url(Storage::url($user->image)) : null,
            'valid_id' => $user->valid_id ? url(Storage::url($user->valid_id)) : null,
            'status' => $status,
            'approved_at' => $status === 'Approved' ? now() : null,
            'denied_at' => $status === 'Denied' ? now() : null,
            'work_examples' => $workExamples,
        ]);
    }

    public function getVerificationHistory()
    {
        // Get all verification history records
        $history = VerificationHistory::all()->map(function ($record) {
            return [
                'id' => $record->user_id,
                'name' => $record->name,
                'email' => $record->email,
                'phone' => $record->phone,
                'contactNumber' => $record->phone,
                'experience' => $record->experience,
                'skills' => $record->skills,
                'role' => $record->role,
                'location' => $record->location,
                'purok' => $record->purok,
                'street' => $record->street,
                'image' => $record->image,
                'valid_id' => $record->valid_id,
                'status' => $record->status,
                'approved_at' => $record->approved_at ? $record->approved_at->toIso8601String() : null,
                'denied_at' => $record->denied_at ? $record->denied_at->toIso8601String() : null,
                'work_examples' => $record->work_examples,
                'for_chat_only' => $record->status === 'ChatBackup',
            ];
        });

        return response()->json($history);
    }
    
    /**
     * Delete a verification history record
     * 
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteVerificationHistory($userId)
    {
        // Find the record by user_id
        $record = VerificationHistory::where('user_id', $userId)->first();
        
        if (!$record) {
            return response()->json(['message' => 'Verification history record not found'], 404);
        }
        
        // Instead of deleting the record completely, create a backup with a special status
        // This ensures the profile data remains available for chat purposes
        $chatBackup = new VerificationHistory();
        $chatBackup->user_id = $record->user_id;
        $chatBackup->name = $record->name;
        $chatBackup->email = $record->email;
        $chatBackup->phone = $record->phone;
        $chatBackup->experience = $record->experience;
        $chatBackup->skills = $record->skills;
        $chatBackup->role = $record->role;
        $chatBackup->location = $record->location;
        $chatBackup->purok = $record->purok;
        $chatBackup->street = $record->street;
        $chatBackup->image = $record->image;
        $chatBackup->valid_id = $record->valid_id;
        $chatBackup->status = 'ChatBackup';  // Special status to indicate this is a backup for chat
        $chatBackup->approved_at = $record->approved_at;
        $chatBackup->denied_at = $record->denied_at;
        $chatBackup->work_examples = $record->work_examples;
        $chatBackup->save();
        
        // Delete the original record
        $record->delete();
        
        return response()->json(['message' => 'Verification history record deleted successfully, chat data preserved']);
    }

    public function getAdminPassword(Request $request)
    {
        $user = User::find(Auth::id());
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $request->validate([
            'currentPassword' => 'required|string'
        ]);

        // Verify current password
        if (!Hash::check($request->currentPassword, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 422);
        }

        return response()->json([
            'password' => $request->currentPassword
        ]);
    }
}
