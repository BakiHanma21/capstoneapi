<?php

namespace App\Http\Controllers\Api;

use App\Models\WorkerWork;
use Illuminate\Http\Request;
use App\Http\Requests\WorkerWorkRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkerWorkResource;

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
        $workerWork->delete();

        return response()->noContent();
    }
}
