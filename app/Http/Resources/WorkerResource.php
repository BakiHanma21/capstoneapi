<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WorkerResource extends JsonResource
{
    public function toArray($request)
    {
        $averageRating = $this->transactions->avg('rating2');
        
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'job' => $this->user->skills,
            'location' => $this->location,
            'experience' => $this->experience,
            'availability' => $this->availability,
            'rating' => $this->user->rating,
            'average_rating' => $averageRating ? number_format($averageRating, 1) : '0',
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            'image' => url(Storage::url($this->user->image)),
            'reviews' => $this->transactions
            ->map(function ($transaction) {
                return [
                    'name' => $transaction->name,
                    'rating' => $transaction->rating2,
                    'text' => $transaction->review2,
                ];
            }),
            'works' => $this->works->map(function ($work) {
                return [
                    'work_id' => $work->work_id,
                    'title' => $work->title,
                    'description' => $work->description,
                    'image' => url(Storage::url($work->image)),
                ];
            }),
        ];
    }

}
