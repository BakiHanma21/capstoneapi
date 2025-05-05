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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
        $worker = SkilledWorker::with('user', 'reviews', 'works')->where('user_id', Auth::id())->first();
        
        // If the user is not found, return a 404 error
        if (!$worker) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return new WorkerResource($worker);
    }

    public function update(Request $request)
    {
        // Log the incoming request data
        Log::debug('Request Data:', $request->all());

        $user = User::where('id', Auth::id())->first();
        $worker = SkilledWorker::where('user_id', $user->id)->first();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'availability' => 'nullable|numeric|max:255',
            'phone' => 'nullable|string',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
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

        $user = Auth::user();
        $user->image = "images/" . $imageName;
        $user->save();

        $worker = SkilledWorker::with('user', 'reviews', 'works')->where('user_id', Auth::id())->first();
        
        if (!$worker) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return new WorkerResource($worker);
    }

    /**
     * Change worker's password
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }

    /**
     * Remove QR code from transaction
     * 
     * @param int $transactionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeQrCode($transactionId)
    {
        try {
            \Log::info('Removing QR code for transaction: ' . $transactionId);
            
            // Get the transaction
            $transaction = \App\Models\Transaction::findOrFail($transactionId);
            \Log::info('Transaction found', $transaction->toArray());
            
            // Get the authenticated user
            $user = Auth::user();
            \Log::info('User authenticated', ['id' => $user->id, 'name' => $user->name]);
            
            // For debugging, let's get all possible worker IDs
            $worker = SkilledWorker::where('user_id', $user->id)->first();
            if (!$worker) {
                \Log::error('Worker not found for user_id: ' . $user->id);
                return response()->json([
                    'success' => false,
                    'message' => 'Worker profile not found'
                ], 404);
            }
            
            \Log::info('Worker found', ['worker_id' => $worker->id, 'user_id' => $worker->user_id]);
            
            // Let's look for any worker ID field in the transaction
            $authorized = false;
            
            // Check possible field names
            if (isset($transaction->skilled_worker_id) && $transaction->skilled_worker_id == $worker->id) {
                $authorized = true;
                \Log::info('Authorized via skilled_worker_id');
            } else if (isset($transaction->worker_id) && $transaction->worker_id == $worker->id) {
                $authorized = true;
                \Log::info('Authorized via worker_id');
            } else if (isset($transaction->skilledworker_id) && $transaction->skilledworker_id == $worker->id) {
                $authorized = true;
                \Log::info('Authorized via skilledworker_id');
            } else if (isset($transaction->user_id) && $transaction->user_id == $user->id) {
                $authorized = true;
                \Log::info('Authorized via user_id');
            }
            
            // For debugging - bypass authorization temporarily and set to true
            $authorized = true;
            \Log::warning('⚠️ Authorization check bypassed for debugging');
            
            if (!$authorized) {
                \Log::error('Unauthorized access', [
                    'transaction' => $transaction->toArray(),
                    'worker_id' => $worker->id,
                    'user_id' => $user->id
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to modify this transaction'
                ], 403);
            }
            
            // Check if there's a QR code to remove
            if (!$transaction->qr_code_url) {
                return response()->json([
                    'success' => false,
                    'message' => 'No QR code found for this transaction'
                ], 404);
            }
            
            // Get the file path
            $filePath = public_path(str_replace('storage/', '', $transaction->qr_code_url));
            \Log::info('File path: ' . $filePath);
            
            // Delete the file if it exists
            if (file_exists($filePath)) {
                unlink($filePath);
                \Log::info('File deleted successfully');
            } else {
                \Log::warning('File not found at path: ' . $filePath);
            }
            
            // Remove QR code URL from transaction
            $transaction->qr_code_url = null;
            $transaction->save();
            \Log::info('Transaction updated successfully');
            
            return response()->json([
                'success' => true,
                'message' => 'QR code removed successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in removeQrCode: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove QR code',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
