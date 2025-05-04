<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    public function getUserProfile()
    {
        try {
            $user = Auth::user();
            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'location' => $user->location,
                'profile_image' => $user->profile_image,
                'purok' => $user->purok,
                'street' => $user->street,
                'rating' => $user->rating,
                'created_at' => $user->created_at
                
            ];

            return response()->json([
                'status' => 'success',
                'data' => $userData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch user profile'
            ], 500);
        }
    }

    public function updateUserProfile(Request $request)
    {
        try {
            $user = Auth::user();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'purok' => 'nullable|string',
                'street' => 'nullable|string',
                
            ]);

            $user->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'data' => $user
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error updating user profile: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update profile'
            ], 500);
        }
    }

    public function updateProfileImage(Request $request)
    {
        try {
            $request->validate([
                'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $user = Auth::user();

            if ($request->hasFile('profile_image')) {
                // Delete old image if exists
                if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                    unlink(public_path($user->profile_image));
                }
                
                // Store in storage/images directory
                $imageName = time() . '.' . $request->profile_image->extension();
                $request->profile_image->move(public_path('storage/images'), $imageName);
                
                // Save path relative to public directory
                $user->profile_image = 'storage/images/' . $imageName;
                $user->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Profile image updated successfully',
                'profile_image' => $user->profile_image,
                'profile_image_url' => asset($user->profile_image)
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating profile image: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update profile image'
            ], 500);
        }
    }

    /**
     * Change user password
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeUserPassword(Request $request)
    {
        try {
            $validated = $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
                'new_password_confirmation' => 'required'
            ]);

            $user = Auth::user();

            // Check if current password matches
            if (!Hash::check($validated['current_password'], $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Current password is incorrect'
                ], 422);
            }

            // Update the password
            $user->password = Hash::make($validated['new_password']);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Password changed successfully'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error changing user password: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to change password',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
