<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuto extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function scopeFilter($query, array $filters){
    $query->when($filters['search'] ?? null, function ($query, $search) {
      $query->where(function ($query) use ($search) {
        $query->where('title', 'like', '%' . $search . '%');
      });
    });
  }
}
