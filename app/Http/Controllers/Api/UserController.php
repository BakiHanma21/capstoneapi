<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\SkilledWorker;
use App\Models\WorkerWork;
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
        $user->availability = 0;
        $user->save();

        // Send email notification if requested
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
        
        // Send email notification if requested
        if ($request->has('sendEmail') && $request->sendEmail && $request->emailType === 'denial') {
            Mail::to($user->email)->send(new AccountDenied($user));
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
        $totalUsers = User::where('role', 'USER')->count(); 
        $totalSkilledWorkers = User::where('role', 'WORKER')->count(); 

        // Return data in JSON format
        return response()->json([
            'totalUsers' => $totalUsers,
            'totalSkilledWorkers' => $totalSkilledWorkers
        ]);
    }

    public function getadminProfile()
    {
        $user = User::where('id', auth()->user()->id)->first();

        return response()->json([
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'profile_picture' => $user->profile_picture,
                'password' => "",
                'role' => $user->skills,
                'image' => url(Storage::url($user->image))
            ]
        ]);
    }

    public function updateadmin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'nullable|min:6',
            'role' => 'nullable|string',
        ]);

        $user = User::find(auth()->user()->id);

        if ($user) {
            $user->email = $validated['email'];
            Log::info('Password: ' . $validated['password']);
            if ($validated['password']) {
                $user->password = Hash::make($validated['password']);
            }
            if ($validated['role']) {
                $user->skills = $validated['role'];
            }
            $user->save();

            return response()->json([
                'message' => 'Profile updated successfully',
                'data' => $user
            ]);
        }

        return response()->json([
            'message' => 'User not found'
        ], 404);
    }

    public function updateProfilePicture(Request $request)
{
    $file = $request->file('profile_picture');

    $imageName = time() . '.' . $file->extension();
    $file->move(public_path('storage/images'), $imageName);

    $user = auth()->user();
    $user->image = "images/" . $imageName;
    $user->save();

    return response()->json([
        'data' => [
            'name' => $user->name,
            'email' => $user->email,
            'profile_picture' => $user->image,
            'password' => "",
            'role' => $user->role,
            'image' => url(Storage::url($user->image))
        ]
    ]);
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

    for ($i = 1; $i <= 2; $i++) {
        $workExampleTitle = $request->input("work_example_{$i}_title");
        $workExampleDescription = $request->input("work_example_{$i}_description");
        $workExampleImage = null;

        if ($request->hasFile("work_example_{$i}_image")) {
            $file = $request->file("work_example_{$i}_image");
            $imageName = time() . '_work_example_' . $i . '.' . $file->extension();
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
    }

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
}
