<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkilledWorkerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        
        // Add user-related fields for account status
        if ($this->user) {
            $data['is_deactivated'] = $this->user->is_deactivated;
            $data['deactivation_reason'] = $this->user->deactivation_reason;
            $data['deletion_scheduled_at'] = $this->user->deletion_scheduled_at;
            $data['deletion_reason'] = $this->user->deletion_reason;
        }
        
        return $data;
    }
}
