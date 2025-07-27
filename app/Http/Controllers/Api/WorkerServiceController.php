<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WorkerServiceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user->skilledWorker) {
                return response()->json(['error' => 'Worker profile not found'], 404);
            }
            
            $services = WorkerService::where('worker_id', $user->skilledWorker->id)->get();
            return response()->json(['data' => $services]);
        } catch (\Exception $e) {
            Log::error('Error in worker services index: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric|min:0'
            ]);

            $user = $request->user();
            if (!$user->skilledWorker) {
                return response()->json(['error' => 'Worker profile not found'], 404);
            }

            $service = new WorkerService([
                'worker_id' => $user->skilledWorker->id,
                'name' => $request->name,
                'price' => $request->price
            ]);

            $service->save();
            return response()->json(['data' => $service], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error in worker services store: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric|min:0'
            ]);

            $user = $request->user();
            if (!$user->skilledWorker) {
                return response()->json(['error' => 'Worker profile not found'], 404);
            }

            $service = WorkerService::where('id', $id)
                ->where('worker_id', $user->skilledWorker->id)
                ->firstOrFail();

            $service->update([
                'name' => $request->name,
                'price' => $request->price
            ]);

            return response()->json(['data' => $service]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error in worker services update: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = request()->user();
            if (!$user->skilledWorker) {
                return response()->json(['error' => 'Worker profile not found'], 404);
            }

            $service = WorkerService::where('id', $id)
                ->where('worker_id', $user->skilledWorker->id)
                ->firstOrFail();

            $service->delete();
            return response()->json(null, 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error in worker services destroy: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
} 