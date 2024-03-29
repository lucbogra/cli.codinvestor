<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function variants()
    {
      return $this->hasMany(SupplierProduct::class);
    }

    public function invoices()
    {
      return $this->morphMany(Invoice::class, 'invoiceable');
    }
}
