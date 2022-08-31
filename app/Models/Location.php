<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function variants()
    {
      return $this->hasMany(SupplierProduct::class);
    }

    public function getQtyByVariantAttribute(){
      return $this->variants()->selectRaw('variant_id, sum(qty) as qty')->groupBy('variant_id')->get()
              ->map(function($ct){
                return [
                  'variant_id' => $ct->variant_id,
                  'sku' => Variant::find($ct->variant_id)->sku,
                  'name' => Variant::find($ct->variant_id)->product->name,
                  'qty' => $ct->qty,
                ];
      });
    }

}
