<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
        public function toArray($request)
    {
        return [
            'title' => $this->title,
            'start' => $this->start,
            'end' => $this->end,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'status' => 'Booked',
            'extendedProps' => [
                'status' => 'Booked',
                'requestId' => $this->customer_id,
            ],
        ];
    }
}
