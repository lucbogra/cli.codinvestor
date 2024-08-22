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
        'commission' => $this->commission,
        'pivot' => $this->whenPivotLoaded('productables', function(){
          return [
            'commission' => $this->pivot->affiliate_commission,
            'affiliate_price' => $this->pivot->affiliate_price,
            'type' => $this->pivot->productable_type=="App\Models\Investor" ? "Investor Product" : "Seller Product",
            'link' => $this->pivot->link
          ];
        }),
        'recommanded_price' => $this->recommanded_price,
        'link' => $this->link,
        'name' => $this->name,
        'active' => $this->active,
        'slug' => $this->slug,
        'description' => $this->description,
        'photo' => $this->photo,
        'categories' => $categories,
        'gallery' => $this->gallery,
        'qty' => $this->variants->sum('qty'),
        'alias' => $this->alias,
        'website_link' => $this->website_link,
        'deleted_at' => $this->deleted_at,
        'exist_request' => $request->user()->investor ?  $this->investor($request->user()->investor->id)->select('productables.status', 'link')->first() : null,
        'countries' => $this->supplier_products()
          ->join('locations', 'supplier_products.location_id', '=', 'locations.id')
          ->selectRaw('locations.country as country, locations.flag_code as flag_code, sum(supplier_products.qty) as qty')
          ->groupBy('country', 'laravel_through_key', 'flag_code')->get(),
        'pricings' => $this->pricings ? json_decode($this->pricings)->pricings : [],
        'niche' => $this->niche,
      ];
    }
}
