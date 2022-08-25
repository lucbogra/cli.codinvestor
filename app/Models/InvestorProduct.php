<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorProduct extends Model
{
    use HasFactory;

    protected $table = 'investor_product';
    protected $fillable = ['status'];

    public function investor(){
      return $this->belongsTo(Investor::class);
    }

    public function product(){
      return $this->belongsTo(Product::class);
    }
}
