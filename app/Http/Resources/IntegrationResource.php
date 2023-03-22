<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IntegrationResource extends JsonResource
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
        'slug' => $this->slug,
        'name' => $this->name,
        'description' => $this->description,
        'status' => $this->status,
        'external_link' => $this->external_link,
        'logo' => $this->logo
      ];
    }
}
