<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
  use HasFactory;
  use SoftDeletes;
  use HasTranslations;

  public $translatable = ['name', 'description'];


  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function resolveRouteBinding($value, $field = null)
  {
    return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
  }

  public function pricings()
  {
    return $this->hasMany(Pricing::class);
  }

  public function scopeFilter($query, array $filters)
  {
    $query->when($filters['search'] ?? null, function ($query, $search) {
      $query->where('name', 'like', '%' . $search . '%')
        ->orWhere('type', 'like', '%' . $search . '%');
    })->when($filters['trashed'] ?? null, function ($query, $trashed) {
      if ($trashed === 'with') {
        $query->withTrashed();
      } elseif ($trashed === 'only') {
        $query->onlyTrashed();
      }
    });
  }

  protected static function booted()
  {
    static::addGlobalScope(new ActiveScope);
    static::addGlobalScope(new PublishedScope);
  }
}
