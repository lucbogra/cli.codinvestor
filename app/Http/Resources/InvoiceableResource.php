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
          'country' => $this->country,
          'phone' => $this->phone,
        ];
    }
}
