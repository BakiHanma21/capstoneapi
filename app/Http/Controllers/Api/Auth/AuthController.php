<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;  // Add this line
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * @group Auth API
     * 
     * Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ($user->availability == 4) {
            return response()->json([
                'error' => 'Your account is disabled. Please contact support.',
            ], 403);
        }

        if ($user->availability == 5) {
            return response()->json([
                'error' => 'Your account is under verification. Please wait.',
            ], 403);
        }        

        $token = $user->createToken('SERVICEEXPRESS')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }



    /**
     * @group Auth API
     * 
     * Register
     */
    public function register(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'experience' => ['nullable', 'string', 'max:255'],
            'availability' => ['nullable', 'string', 'max:255'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'string', 'max:255'],
            'valid_id' => ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048'],
            'purok' => ['nullable', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
        ]);
        

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Hash password
        ]);

        // Login user after registration
        Auth::login($user);

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
        ], 201);
    }

    /**
     * @group Auth API
     * 
     * Forgot Password
     */
    // Request Password Reset Link
    public function forgotPassword(Request $request)
{
    try {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Log for debugging
        Log::info('Attempting password reset for email: ' . $request->email);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent to your email. Please check your Email or your Spam section'], 200);
        } else {
            Log::error('Failed to send reset link: ' . $status);
            return response()->json(['message' => 'Error sending reset link. Please try again later.'], 400);
        }
    } catch (\Exception $e) {
        Log::error('Exception in forgotPassword: ' . $e->getMessage());
        return response()->json(['message' => 'Something went wrong!', 'error' => $e->getMessage()], 500);
    }
}

    // Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password has been reset.'], 200)
            : response()->json(['message' => 'Invalid token or email.'], 400);
    }
}