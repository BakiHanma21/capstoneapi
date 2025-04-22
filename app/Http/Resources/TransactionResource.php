<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $array = parent::toArray($request);
        
        // Just return the relative paths without using url() helper
        if (isset($array['qr_code_url'])) {
            $array['qr_code_url'] = $this->qr_code_url;
        }
        if (isset($array['receipt_url'])) {
            $array['receipt_url'] = $this->receipt_url;
        }
        
        return $array;
    }
}
