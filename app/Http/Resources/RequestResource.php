<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
class RequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $notification=DatabaseNotification::where('data->id',$this->id)->where('read_at',null)->count();
        return [
            'id' => $this->id,
            'costumer_id' => $this->costumer_id,
            'costumer' => $this->costumer,
            'answer' => $this->answer,
            'product' => $this->product,
            'platform' => $this->platform,
            'type' => $this->type,
            'music' => $this->music,
            'voice_over' => $this->voice_over,
            'duration' => $this->duration,
            'observation' => $this->observation,
            'created_at'=>date_format($this->created_at,'Y-m-d'),
            'read'=>$notification<1 ? true : false
        ];
    }
}
