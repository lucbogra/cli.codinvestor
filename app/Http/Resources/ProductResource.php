<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      $categories = $this->whenLoaded('categories');
      return [
        'id' => $this->id,
        'sku' => $this->sku,
        'original_price' => $this->original_price,
        'recommanded_price' => $this->recommanded_price,
        'commission' => $this->commission,
        'link' => $this->link,
        'name' => $this->name,
        'active' => $this->active,
        'slug' => $this->slug,
        'description' => $this->description,
        'photo' => $this->photo,
        'categories' => $categories,
        'gallery' => $this->gallery,
        'link' => $this->link,
        'qty' => $this->variants->sum('qty'),
        'alias' => $this->alias,
        'website_link' => $this->website_link,
        'deleted_at' => $this->deleted_at,
        'exist_request' => $this->investor($request->user()->investor->id)->select('status', 'link')->first(),
        'countries' => $this->supplier_products()
        ->join('locations', 'supplier_products.location_id', '=', 'locations.id')
        ->selectRaw('locations.country as country, sum(supplier_products.qty) as qty')
        ->groupBy('country', 'laravel_through_key')->get(),
        'pricings' => $this->pricings ? json_decode($this->pricings)->pricings : [],
      ];
    }
}
