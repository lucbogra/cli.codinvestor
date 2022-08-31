<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProduct extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id', 'variant_id', 'location_id', 'qty', 'price'];

    public function variant(){
      return $this->belongsTo(Variant::class);
    }

    public function location(){
      return $this->belongsTo(Location::class);
    }

    public function supplier(){
      return $this->belongsTo(Supplier::class);
    }

}
