<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvestorResource extends JsonResource
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
        'first_name' => $this->first_name,
        'last_name' => $this->last_name,
        'email' => $this->email,
        'phone' => $this->phone,
        'address' => $this->address,
        'city' => $this->city,
        'state' => $this->state,
        'zip' => $this->zip,
        'country' => $this->country,
        'company' => $this->company,
        'website' => $this->website,
        'title' => $this->title,
      ];
    }
}
