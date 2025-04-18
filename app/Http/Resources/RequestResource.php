<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        // Log the start_time
        Log::info('Start time: ' . $this->start_time);

        return [
            'id' => $this->booking_id,
            'name' => $this->customer->name,
            'date' => $this->start,
            'end_date' => $this->end,
            'title' => $this->title,
            'average_rating' => $this->average_rating,
            'status' => $this->status,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'proposedCost' => $this->amount,
            'userPicture' => $this->image
                ? url(Storage::url($this->image)) 
                : null,
        ];
    }
}

