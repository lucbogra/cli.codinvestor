<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FundingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      return [
        'id' => $this->id,
        'amount' => $this->amount,
        'remain' => $this->remain,
        'currency' => $this->currency,
        'date' => $this->date,
        'invoice' => $this->whenLoaded('invoice'),
        'file' => $this->file,
        'status' => $this->status,
        'created_at' => $this->created_at->format('Y-m-d'),
        'slug' => $this->slug,
      ];
    }
}
