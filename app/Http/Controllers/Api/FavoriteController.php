<?php

namespace App\Http\Controllers\Api;

use App\Models\Favorite;
use App\Models\User;
use App\Models\SkilledWorker;
use Illuminate\Http\Request;
use App\Http\Requests\FavoriteRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\WorkerResource;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    /**
     * @group Favorite API
     * 
     * Get All Favorite
     */
    public function index(Request $request)
    {
        
        $skilledWorkers = SkilledWorker::with('user', 'reviews', 'works')
            ->whereHas('favorites', function ($query) {
                $query->where('customer_id', auth()->user()->id);
            })
            ->get();

        Log::info('Skilled Workers Fetched:'. auth()->user()->id);
        return WorkerResource::collection($skilledWorkers);
    }

    

    /**
     * @group Favorite API
     * 
     * Store Favorite
     */
    public function store(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $user = SkilledWorker::where('user_id', $request->worker_id)->first();

        Favorite::create([
            'worker_id' => $user->id,
            'customer_id' => $request->user_id,
        ]);

        return response()->json(['message' => 'Worker saved as favorite successfully']);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $user = SkilledWorker::where('user_id', $request->worker_id)->first();

        $fav = Favorite::where('worker_id', $user->id)->where('customer_id', $request->user_id)->delete();

        return response()->json(['message' => 'Worker removed as favorite successfully']);
    }


    /**
     * @group Favorite API
     * 
     * Show Favorite
     */

    public function show(Favorite $favorite): Favorite
    {
        return $favorite;
    }

     /**
     * @group Favorite API
     * 
     * Update Favorite
     */
    public function update(FavoriteRequest $request, Favorite $favorite): Favorite
    {
        $favorite->update($request->validated());

        return $favorite;
    }

    /**
     * @group Favorite API
     * 
     * Delete Favorite
     */
    public function destroy(Favorite $favorite): Response
    {
        $favorite->delete();

        return response()->noContent();
    }
}