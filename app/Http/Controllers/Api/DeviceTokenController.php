<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DeviceTokenController extends Controller
{
    /**
     * Register or update device token
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
            'device_type' => 'required|string|in:web,android,ios'
        ]);

        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Update user with device token using update method
            User::where('id', $user->id)->update([
                'device_token' => $request->device_token,
                'device_type' => $request->device_type
            ]);

            Log::info('Device token registered', [
                'user_id' => $user->id,
                'device_type' => $request->device_type,
                'platform' => $request->device_type
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Device token registered successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error registering device token', [
                'error' => $e->getMessage(),
                'device_type' => $request->device_type
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to register device token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete device token
     */
    public function destroy(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Get the device type before removing it for logging
            $deviceType = $user->device_type;

            // Remove device token using update method
            User::where('id', $user->id)->update([
                'device_token' => null,
                'device_type' => null
            ]);

            Log::info('Device token removed', [
                'user_id' => $user->id,
                'previous_device_type' => $deviceType
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Device token removed successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error removing device token', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to remove device token',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 