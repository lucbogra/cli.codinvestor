<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
      'ref' => $this->ref,
      'duplicate' => $this->duplicate,
      'created_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
      'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
      'customer_name' => $this->customer_name,
      'phone' => $this->phone,
      'country' => $this->country,
      'customer_city' => $this->customer_city,
      'customer_region' => $this->customer_region,
      'customer_address' => $this->customer_address,
      'product_name' => $this->product_name,
      'price' => $this->price,
      'website' => $this->website,
      'codprice' => $this->codprice,
      'status' => $this->status,
      'tries' => $this->tries,
      'product_link' => $this->product_link,
      'note' => $this->note,
      'delayed_at' => $this->delayed_at,
      'delayed_date' => $this->delayed_date,
      'delivered_at' => $this->delivered_at,
      'returned_at' => $this->returned_at,
      'commission' => '$'.$this->commission,
      'status_date' => Carbon::parse($this->status_date)->format('Y-m-d'),
      'cancel_reason' => $this->cancel_reason,
      'before_closed' => $this->before_closed,
      'supplier_products' => $this->whenLoaded('supplier_products')
    ];
  }
}
