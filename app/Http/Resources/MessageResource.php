<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
        'title' => $this->title,
        'content' => $this->content,
        'read_at' => $this->whenPivotLoaded('user_message', function() {
          return $this->pivot->read_at;
        }) ,
        'time' => Carbon::parse($this->created_at)->diffForHumans(),
        'created_at' => $this->created_at->format('Y-m-d'),
        'created_at_full' => $this->created_at->format('F j, Y H:i'),
      ];
    }
}
