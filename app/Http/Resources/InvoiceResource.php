<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    $admin = $this->whenLoaded('admin');
    $invoiceable = $this->whenLoaded('invoiceable');
    $fundings = $this->whenLoaded('fundings');
    return [
      'created_at' => $this->created_at->format('Y-m-d'),
      'slug' => $this->slug,
      'type' => $this->type,
      'amount' => $this->amount,
      'status' => $this->status,
      'paid_date' => $this->paid_date,
      'payment_method' => $this->payment_method,
      'file_url' => $this->file_url,
      'invoiceable' => new InvoiceableResource($invoiceable),
      'admin' => $admin,
      'currency' => $this->currency,
      'products' => collect(json_decode($this->datas)->products)->map(function ($line) {
        $product = Product::withoutTrashed()->find($line->product_id);
        if ($product)
          return [
            'name' => $product->name,
            'sku' => $product->sku,
            'photo' => $product->photo,
            'amount' => $line->amount,
          ];
      }),
      'fundings' => $fundings,
    ];
  }
}
