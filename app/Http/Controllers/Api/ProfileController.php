<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function getProfile()
    {
        return response()->json(['data' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(['message' => 'Profile updated successfully']);
    }

    public function getadminProfile()
    {
        $user = User::where('id', auth()->user()->id)->first();

        return response()->json([
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'profile_picture' => $user->profile_picture,
                'password' => $user->password,
                'role' => $user->role
            ]
        ]);
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
            $user->save();
        }
        return response()->json(['profile_picture' => $user->profile_picture, 'message' => 'Profile picture updated successfully']);
    }


    public function show()
    {
        $user = SkilledWorker::with('user', 'reviews', 'works')->where('id', auth()->user()->id)->first();
        return WorkerResource::collection($user);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'availability' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'mapsLink' => 'nullable|url',
            'skills' => 'nullable|string',
            'experience' => 'nullable|string',
            'workDone' => 'nullable|string',
            'workImage' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'profileImage' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $worker = Auth::user();
        $worker->name = $validated['name'];
        $worker->location = $validated['location'];
        $worker->availability = $validated['availability'];
        $worker->phone = $validated['phone'];
        $worker->email = $validated['email'];
        $worker->maps_link = $validated['mapsLink'];
        $worker->skills = $validated['skills'];
        $worker->experience = $validated['experience'];
        $worker->work_done = $validated['workDone'];

        if ($request->hasFile('workImage')) {
            $worker->work_image = $request->file('workImage')->store('work_images');
        }

        if ($request->hasFile('profileImage')) {
            $worker->profile_image = $request->file('profileImage')->store('profile_images');
        }

        $worker->save();

        return response()->json(['message' => 'Profile updated successfully!', 'worker' => $worker]);
    }
    
}
