<?php

namespace App\Http\Controllers\Api;

use App\Models\WorkRequest;
use Illuminate\Http\Request;
use App\Http\Requests\WorkRequestRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkRequestResource;

use Illuminate\Support\Facades\Log;
use App\Models\SkilledWorker;
use App\Models\Booking;
use App\Models\User;
use App\Models\Transaction;
use App\Http\Resources\RequestResource;

class WorkRequestController extends Controller
{
    /**
     * @group WorkRequest API
     * 
     * Get All WorkRequest
     */
    public function index()
    {
        $workers = SkilledWorker::with('user', 'reviews', 'works')->get();
        return WorkerResource::collection($workers);
    }

    public function destroy($id)
    {
        $worker = Worker::find($id);

        if (!$worker) {
            return response()->json(['error' => 'Worker not found'], 404);
        }

        $worker->delete();
        return response()->json(['message' => 'Worker deleted successfully']);
    }

    public function postWorker(Request $request)
    {
        $workerData = $request->all();

        return response()->json(['message' => 'Worker posted successfully']);
    }


    public function getWorkerRequests($userId)
    {
        Log::info('User ID: ' . $userId);
    
        $worker = User::where('id', $userId)
                     ->where('role', 'WORKER')
                     ->firstOrFail();
    
        $requests = Booking::where('worker_id', $worker->id)
                          ->where('status', 'PENDING')
                          ->with('customer')
                          ->get();
    
        foreach ($requests as $request) {
            $customer = $request->customer;
            $averageRating = Transaction::where('customer_id', $customer->id)
                                      ->avg('rating');
        
            $request->average_rating = $averageRating ? number_format($averageRating, 1) : 'Not yet rated';
        }
                        
        return RequestResource::collection($requests);
    }
    


    public function updateStatus(Request $request, $userId)
    {
        $requestModel = Booking::findOrFail($userId);
        $requestModel->status = $request->status;
        $customer = User::where('id', $requestModel->customer_id)->first();
        $requestModel->save();

        $deleteBooking = Booking::where('status', 'PENDING')
                        ->where(function ($query) use ($requestModel) {
                            $query->whereBetween('start', [$requestModel->start, $requestModel->end])
                                  ->orWhereBetween('end', [$requestModel->start, $requestModel->end])
                                  ->orWhere(function ($query) use ($requestModel) {
                                      $query->where('start', '<=', $requestModel->start)
                                            ->where('end', '>=', $requestModel->end);
                                  });
                        })
                        ->delete();

        $transaction = Transaction::create([
            'request_id' => auth()->user()->id,
            'customer_id' => $requestModel->customer_id,
            'title' => $requestModel->title,
            'name' => $customer->name,
            'description' => $requestModel->description,
            'payment_status' => "PENDING",
            'payment_date' => $requestModel->end,
            'amount' => $requestModel->amount,
        ]);

        return response()->json(['message' => 'Approved successfully.']);
    }

    public function getAvailableEvents($worker_id)
    {
        $skilledworker = SkilledWorker::where('user_id', $worker_id)->first();
        $availableEvents = Booking::where('worker_id', $skilledworker->id)->where('status', 'CONFIRMED')->get();
        return response()->json(['data' => $availableEvents]);
    }
}
