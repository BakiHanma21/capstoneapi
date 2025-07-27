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
            'is_deactivated' => $this->user->is_deactivated,
            'deactivation_reason' => $this->user->deactivation_reason,
            'deletion_scheduled_at' => $this->user->deletion_scheduled_at,
            'deletion_reason' => $this->user->deletion_reason,
            'services' => $this->services->map(function ($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'price' => $service->price
                ];
            }),
            'reviews' => $this->transactions
            ->map(function ($transaction) {
                // Get the customer user information to ensure we have the latest profile data
                $customer = \App\Models\User::find($transaction->customer_id);
                
                // Format the image URL correctly to avoid duplicate 'storage/' paths
                $imageUrl = null;
                if ($customer && $customer->image) {
                    if (str_starts_with($customer->image, 'http')) {
                        $imageUrl = $customer->image;
                    } else if (str_starts_with($customer->image, 'storage/')) {
                        $imageUrl = url($customer->image);
                    } else {
                        $imageUrl = url('storage/' . $customer->image);
                    }
                }
                
                return [
                    'user_id' => $transaction->customer_id, // Store the reviewer's user ID
                    'reviewed_by' => $transaction->customer_id, // Alternative field for compatibility
                    'name' => $customer ? $customer->name : $transaction->name, // Use customer name if available
                    'rating' => $transaction->rating2,
                    'text' => $transaction->review2,
                    'image' => $imageUrl, // Use properly formatted image URL
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
