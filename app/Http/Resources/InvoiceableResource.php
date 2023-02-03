<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceableResource extends JsonResource
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
        'user_id' => $this->user_id,
        'name' => $this->name,
        'email' => $this->user->email,
        'phone' => $this->phone,
        'address' => $this->address,
        'city' => $this->city,
        'zip' => $this->zip,
        'country' => $this->country,
        'company' => $this->company,
        'website' => $this->website,
        'can_download' => $this->company != null && $this->address != null && $this->phone != null ? true : false
      ];
    }
}
