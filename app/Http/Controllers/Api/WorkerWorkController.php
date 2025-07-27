<?php

namespace App\Http\Controllers\Api;

use App\Models\WorkerWork;
use Illuminate\Http\Request;
use App\Http\Requests\WorkerWorkRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkerWorkResource;
use App\Models\SkilledWorker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WorkerWorkController extends Controller
{
    /**
     * @group WorkerWork API
     * 
     * Get All WorkerWork
     */
    public function index(Request $request)
    {
        $workerWorks = WorkerWork::paginate();

        return WorkerWorkResource::collection($workerWorks);
    }

    /**
     * @group WorkerWork API
     * 
     * Store WorkerWork
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'worker_id' => 'required',
            'title' => 'required|string',
            'description' => 'required|string',
            'work_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        Log::info('Creating new worker work');
        Log::info('Request data: ', $request->all());
        
        // Get authenticated user ID
        $authUserId = Auth::id();
        Log::info('Auth user ID: ' . $authUserId);
        
        // Get the worker profile for the authenticated user
        $worker = SkilledWorker::where('user_id', $authUserId)->first();
        
        // Debug worker information
        if ($worker) {
            Log::info('Worker found:', [
                'worker_id' => $worker->id,
                'worker_id_type' => gettype($worker->id),
                'user_id' => $worker->user_id,
                'user_id_type' => gettype($worker->user_id)
            ]);
            
            // Dump the entire worker object for debugging
            Log::info('Worker object:', $worker->toArray());
        } else {
            Log::error('No worker profile found for user ID: ' . $authUserId);
            return response()->json(['error' => 'No worker profile found'], 403);
        }
        
        // Debug request worker_id
        $requestWorkerId = $validatedData['worker_id'];
        Log::info('Request worker_id:', [
            'value' => $requestWorkerId,
            'type' => gettype($requestWorkerId)
        ]);
        
        // Convert both to strings for reliable comparison
        $workerIdStr = (string) $worker->id;
        $requestWorkerIdStr = (string) $requestWorkerId;
        
        Log::info('Comparing worker IDs as strings:', [
            'worker_id_str' => $workerIdStr,
            'request_worker_id_str' => $requestWorkerIdStr,
            'are_equal' => ($workerIdStr === $requestWorkerIdStr)
        ]);
        
        // TEMPORARILY BYPASS AUTHORIZATION CHECK FOR DEBUGGING
        // This will allow us to see if the rest of the process works
        /*
        if ($workerIdStr !== $requestWorkerIdStr) {
            Log::error('Unauthorized access. User ID: ' . $authUserId . 
                      ', Request Worker ID: ' . $requestWorkerId . 
                      ', Auth Worker ID: ' . $worker->id);
            return response()->json(['error' => 'Unauthorized to add work to this profile'], 403);
        }
        */
        
        // Create new work record
        $work = new WorkerWork();
        $work->worker_id = $worker->id; // Use the actual worker ID from the database
        $work->title = $validatedData['title'];
        $work->description = $validatedData['description'];
        
        // Handle image upload
        if ($request->hasFile('work_image')) {
            Log::info('Processing image upload');
            $file = $request->file('work_image');
            $imageName = time() . '.' . $file->extension();
            
            try {
                // Make sure the directory exists
                if (!file_exists(public_path('storage/works'))) {
                    mkdir(public_path('storage/works'), 0755, true);
                    Log::info('Created storage/works directory');
                }
                
                $file->move(public_path('storage/works'), $imageName);
                // Set image path in database
                $work->image = "works/" . $imageName;
                Log::info('Image uploaded: works/' . $imageName);
            } catch (\Exception $e) {
                Log::error('Error uploading image: ' . $e->getMessage());
                return response()->json(['error' => 'Error uploading image: ' . $e->getMessage()], 500);
            }
        }
        
        $work->save();
        Log::info('Work created successfully with ID: ' . $work->id);
        
        return response()->json([
            'success' => true,
            'message' => 'Work added successfully',
            'data' => $work
        ], 201);
    }

    /**
     * @group WorkerWork API
     * 
     * Show WorkerWork
     */
    public function show(WorkerWork $workerWork): WorkerWork
    {
        return $workerWork;
    }

     /**
     * @group WorkerWork API
     * 
     * Update WorkerWork
     */
    public function update(WorkerWorkRequest $request, WorkerWork $workerWork): WorkerWork
    {
        $workerWork->update($request->validated());

        return $workerWork;
    }

    /**
     * @group WorkerWork API
     * 
     * Delete WorkerWork
     */
    public function destroy(WorkerWork $workerWork): Response
    {
        // Check if the authenticated user is the owner of the work
        $worker = SkilledWorker::where('user_id', Auth::id())->first();
        if (!$worker || $workerWork->worker_id != $worker->id) {
            return new Response(['error' => 'Unauthorized to delete this work'], 403);
        }

        $workerWork->delete();

        return response()->noContent();
    }

    /**
     * Update worker work with image upload
     */
    public function updateWithImage(Request $request, string $id)
    {
        Log::info('Updating worker work with ID: ' . $id);
        Log::info('Request data: ', $request->all());
        
        $work = WorkerWork::find($id);
        if (!$work) {
            Log::error('Work not found with ID: ' . $id);
            return response()->json(['error' => 'Work not found'], 404);
        }
        
        // Check if the authenticated user is the owner of the work
        $worker = SkilledWorker::where('user_id', Auth::id())->first();
        if (!$worker || $work->worker_id != $worker->id) {
            Log::error('Unauthorized access. User ID: ' . Auth::id() . ', Worker ID: ' . ($worker ? $worker->id : 'null'));
            return response()->json(['error' => 'Unauthorized to update this work'], 403);
        }
        
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'work_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        Log::info('Validated data: ', $validatedData);
        
        // Update text fields if provided
        if ($request->has('title')) {
            $work->title = $validatedData['title'];
        }
        
        if ($request->has('description')) {
            $work->description = $validatedData['description'];
        }
        
        // Handle image upload if provided
        if ($request->hasFile('work_image')) {
            Log::info('Processing image upload');
            $file = $request->file('work_image');
            $imageName = time() . '.' . $file->extension();
            
            try {
                $file->move(public_path('storage/works'), $imageName);
                // Update image path in database
                $work->image = "works/" . $imageName;
                Log::info('Image uploaded: works/' . $imageName);
            } catch (\Exception $e) {
                Log::error('Error uploading image: ' . $e->getMessage());
                return response()->json(['error' => 'Error uploading image: ' . $e->getMessage()], 500);
            }
        }
        
        $work->save();
        Log::info('Work updated successfully');
        
        return response()->json([
            'success' => true,
            'message' => 'Work updated successfully',
            'data' => $work
        ]);
    }
}
