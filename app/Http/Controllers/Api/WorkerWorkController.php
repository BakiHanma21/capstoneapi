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
    public function store(WorkerWorkRequest $request): WorkerWork
    {
        return WorkerWork::create($request->validated());
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
