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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountDeletedMail;
use App\Models\WorkerWork;
use App\Models\WorkerService;
use App\Models\Review;

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
            $query->whereNotIn('availability', [5, 4])
                  ->where(function($q) {
                      $q->where('is_deactivated', false)
                        ->orWhereNull('is_deactivated');
                  })
                  ->whereNull('deletion_scheduled_at');
        })
        ->get();
        return WorkerResource::collection($skilledWorkers);
    }


    /**
     * Get Single SkilledWorker
     */
    public function show($id = null)
    {
        // If no ID is provided, use the authenticated user's ID
        if ($id === null) {
            $worker = SkilledWorker::with('user', 'reviews', 'works')->where('user_id', Auth::id())->first();
        } else {
            // Find the worker by the provided ID
            $worker = SkilledWorker::with('user', 'reviews', 'works')->where('user_id', $id)->first();
        }
        
        // If the worker is not found, return a 404 error
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
        // The save() method is inherited from the Authenticatable class
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
            Log::info('Removing QR code for transaction: ' . $transactionId);
            
            // Get the transaction
            $transaction = \App\Models\Transaction::findOrFail($transactionId);
            Log::info('Transaction found', $transaction->toArray());
            
            // Get the authenticated user
            $user = Auth::user();
            Log::info('User authenticated', ['id' => $user->id, 'name' => $user->name]);
            
            // For debugging, let's get all possible worker IDs
            $worker = SkilledWorker::where('user_id', $user->id)->first();
            if (!$worker) {
                Log::error('Worker not found for user_id: ' . $user->id);
                return response()->json([
                    'success' => false,
                    'message' => 'Worker profile not found'
                ], 404);
            }
            
            Log::info('Worker found', ['worker_id' => $worker->id, 'user_id' => $worker->user_id]);
            
            // Let's look for any worker ID field in the transaction
            $authorized = false;
            
            // Check possible field names
            if (isset($transaction->skilled_worker_id) && $transaction->skilled_worker_id == $worker->id) {
                $authorized = true;
                Log::info('Authorized via skilled_worker_id');
            } else if (isset($transaction->worker_id) && $transaction->worker_id == $worker->id) {
                $authorized = true;
                Log::info('Authorized via worker_id');
            } else if (isset($transaction->skilledworker_id) && $transaction->skilledworker_id == $worker->id) {
                $authorized = true;
                Log::info('Authorized via skilledworker_id');
            } else if (isset($transaction->user_id) && $transaction->user_id == $user->id) {
                $authorized = true;
                Log::info('Authorized via user_id');
            }
            
            // For debugging - bypass authorization temporarily and set to true
            $authorized = true;
            Log::warning('⚠️ Authorization check bypassed for debugging');
            
            if (!$authorized) {
                Log::error('Unauthorized access', [
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
            Log::info('File path: ' . $filePath);
            
            // Delete the file if it exists
            if (file_exists($filePath)) {
                unlink($filePath);
                Log::info('File deleted successfully');
            } else {
                Log::warning('File not found at path: ' . $filePath);
            }
            
            // Remove QR code URL from transaction
            $transaction->qr_code_url = null;
            $transaction->save();
            Log::info('Transaction updated successfully');
            
            return response()->json([
                'success' => true,
                'message' => 'QR code removed successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in removeQrCode: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove QR code',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check the status of the authenticated user's account
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAccountStatus()
    {
        $user = Auth::user();
        $status = 'active';
        
        // Check if account is deactivated
        if ($user->is_deactivated) {
            $status = 'deactivated';
        }
        
        // Check if account is pending deletion
        if ($user->deletion_scheduled_at && Carbon::parse($user->deletion_scheduled_at)->isFuture()) {
            $status = 'pending_deletion';
        }
        
        return response()->json([
            'status' => $status
        ]);
    }
    
    /**
     * Verify user password for sensitive actions
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password is incorrect'
            ], 422);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Password verified successfully'
        ]);
    }
    
    /**
     * Deactivate user account
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivateAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'reason' => 'required|string|max:500',
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password is incorrect'
            ], 422);
        }
        
        // Update user and worker availability status
        $user->is_deactivated = true;
        $user->deactivation_reason = $request->reason;
        $user->availability = 0; // Set to unavailable
        $user->save();
        
        // Update skilled worker availability
        $worker = SkilledWorker::where('user_id', $user->id)->first();
        if ($worker) {
            $worker->availability = 0;
            $worker->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Account deactivated successfully'
        ]);
    }
    
    /**
     * Reactivate user account
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function reactivateAccount()
    {
        $user = Auth::user();
        
        // Reactivate account
        $user->is_deactivated = false;
        $user->deactivation_reason = null;
        $user->availability = 0; // Set to unavailable by default
        $user->save();
        
        // Update skilled worker availability
        $worker = SkilledWorker::where('user_id', $user->id)->first();
        if ($worker) {
            $worker->availability = 0;
            $worker->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Account reactivated successfully'
        ]);
    }
    
    /**
     * Schedule account for deletion
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function scheduleAccountDeletion(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);
        
        $user = Auth::user();
        
        // Schedule deletion for 7 days from now
        $deletionDate = now()->addDays(7);
        
        $user->deletion_scheduled_at = $deletionDate;
        $user->deletion_reason = $request->reason;
        $user->availability = 0; // Set to unavailable
        $user->is_deactivated = true; // Also deactivate the account
        $user->save();
        
        // Update skilled worker availability
        $worker = SkilledWorker::where('user_id', $user->id)->first();
        if ($worker) {
            $worker->availability = 0;
            $worker->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Account scheduled for deletion',
            'deletion_date' => $deletionDate
        ]);
    }
    
    /**
     * Cancel scheduled account deletion
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelAccountDeletion()
    {
        $user = Auth::user();
        
        $user->deletion_scheduled_at = null;
        $user->deletion_reason = null;
        $user->is_deactivated = false;
        $user->availability = 0; // Set to unavailable by default
        $user->save();
        
        // Update skilled worker availability
        $worker = SkilledWorker::where('user_id', $user->id)->first();
        if ($worker) {
            $worker->availability = 0;
            $worker->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Account deletion cancelled successfully'
        ]);
    }
    
    /**
     * Process permanent account deletion for accounts past grace period
     * This should be called by a scheduled task
     * 
     * @return void
     */
    public function processPendingDeletions()
    {
        $users = User::where('deletion_scheduled_at', '<', now())
            ->whereNotNull('deletion_scheduled_at')
            ->get();
            
        foreach ($users as $user) {
            // Send email notification
            try {
                Mail::to($user->email)->send(new AccountDeletedMail($user));
            } catch (\Exception $e) {
                Log::error('Failed to send account deletion email: ' . $e->getMessage());
            }
            
            // Delete user data
            $worker = SkilledWorker::where('user_id', $user->id)->first();
            if ($worker) {
                // Delete worker works
                WorkerWork::where('skilled_worker_id', $worker->id)->delete();
                
                // Delete worker services
                WorkerService::where('skilled_worker_id', $worker->id)->delete();
                
                // Delete reviews
                Review::where('skilled_worker_id', $worker->id)->delete();
                
                // Delete worker
                $worker->delete();
            }
            
            // Delete user
            $user->delete();
        }
    }
}
