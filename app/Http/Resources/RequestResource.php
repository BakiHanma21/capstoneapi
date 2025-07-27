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
            'service' => $this->title,
            'date' => $this->start,
            'end_date' => $this->end,
            'title' => $this->title,
            'average_rating' => $this->average_rating,
            'status' => $this->status,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'proposedCost' => $this->amount,
            'user_profile_image' => $this->user_profile_image, // Use the computed user_profile_image from controller
            'userPicture' => $this->image ? url(Storage::url($this->image)) : null, // Booking reference image
            'phone' => $this->customer->phone, // Idagdag ang phone
            'location' => $this->customer->location, // Idagdag ang location
            'purok' => $this->customer->purok, // Idagdag ang purok
            'street' => $this->customer->street, // Idagdag ang street
            'email' => $this->customer->email, // Idagdag ang email
            'removed_at' => $this->removed_at // Add removed_at field
        ];
    }
}

