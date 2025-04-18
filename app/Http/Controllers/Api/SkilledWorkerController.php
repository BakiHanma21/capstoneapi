<?php

namespace App\Http\Controllers\Api;

use App\Models\SkilledWorker;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\SkilledWorkerRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkerResource;
use App\Http\Resources\SkilledWorkerResource;

class SkilledWorkerController extends Controller
{
    /**
     * @group SkilledWorker API
     * 
     * Get All SkilledWorker
     */
    public function index(Request $request)
{
    $skilledWorkers = SkilledWorker::with('user', 'transactions', 'works')
    ->whereHas('user', function ($query) {
        $query->whereNotIn('availability', [5, 4]);
    })
    ->get();
    return WorkerResource::collection($skilledWorkers);
}


    /**
     * Get Single SkilledWorker
     */
    public function show()
    {
        $user = SkilledWorker::with('user', 'reviews', 'works')->where('user_id', auth()->user()->id)->first();
        
        // If the user is not found, return a 404 error
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return new WorkerResource($user);
    }

    public function update(Request $request)
{
    // Log the incoming request data
    \Log::debug('Request Data:', $request->all());

    $user = User::where('id', auth()->user()->id)->first();
    $worker = SkilledWorker::where('user_id', $user->id)->first();

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'location' => 'nullable|string|max:255',
        'job' => 'nullable|string|max:255',
        'availability' => 'nullable|numeric|max:255',
        'phone' => 'nullable|string',
        'email' => 'required|email|max:255|unique:users,email,' . auth()->user()->id,
        'experience' => 'nullable|integer|min:0',
    ]);

    // Update worker's profile
    $worker->location = $data['location'];
    $worker->availability = $data['availability'];
    $worker->job = $data['job'];
    $worker->experience = $data['experience'];
    $worker->save();

    // Update user's profile
    $user->name = $data['name'];
    $user->location = $data['location'];
    $user->experience = $data['experience'];
    $user->availability = $data['availability'];
    $user->skills = $data['job'];
    $user->phone = $data['phone'];
    if (isset($data['email'])) {
        $user->email = $data['email'];
    }
    $user->save();

    return response()->json(['data' => $user], 200);
}

    public function updateworkerprofile(Request $request) {
        $file = $request->file('profile_picture');

        $imageName = time() . '.' . $file->extension();
        $file->move(public_path('storage/images'), $imageName);

        $user = auth()->user();
        $user->image = "images/" . $imageName;
        $user->save();

        $user = SkilledWorker::with('user', 'reviews', 'works')->where('user_id', auth()->user()->id)->first();
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return new WorkerResource($user);
    }
}
