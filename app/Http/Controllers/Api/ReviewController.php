<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use App\Models\SkilledWorker;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * @group Review API
     * 
     * Get All Review
     */
    public function index(Request $request)
    {
        $reviews = Review::paginate();

        return ReviewResource::collection($reviews);
    }

    /**
     * @group Review API
     * 
     * Store Review
     */
    public function store(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|exists:skilled_workers,user_id',
            'name' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
            'text' => 'required|string|max:500',
        ]);

        $worker_id = SkilledWorker::where('user_id', $request->worker_id)->first();

        Review::create([
            'worker_id' => $worker_id->id,
            'name' => auth()->user()->name,
            'rating' => $request->rating,
            'text' => $request->text,
        ]);

        return response()->json(['message' => 'Review submitted successfully']);
    }

    /**
     * @group Review API
     * 
     * Show Review
     */
    public function show(Review $review): Review
    {
        return $review;
    }

     /**
     * @group Review API
     * 
     * Update Review
     */
    public function update(ReviewRequest $request, Review $review): Review
    {
        $review->update($request->validated());

        return $review;
    }

    /**
     * @group Review API
     * 
     * Delete Review
     */
    public function destroy(Review $review): Response
    {
        $review->delete();

        return response()->noContent();
    }
}
