<?php

namespace App\Models;

use Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
  use HasFactory, SoftDeletes;

  protected $casts = [
    'gallery' => 'array',
  ];

  protected $dates = [
    'created_at',
    'updated_at',
  ];

  public function resolveRouteBinding($value, $field = null)
  {
    return $this->where($field ?? 'slug', $value)->withTrashed()->firstOrFail();
  }

  public function scopeActive($query)
  {
    $query->where('active', 1);
  }

  public function scopeFilter($query, array $filters)
  {
    $query->when($filters['search'] ?? null, function ($query, $search) {
      $query->where('name', 'like', '%' . $search . '%');
    })->when($filters['country'] ?? null, function ($query, $country) {
        $query->whereIn(
          'id',
          DB::table('products')->join('variants', 'products.id', '=', 'variants.product_id')
            ->join('supplier_products', 'variants.id', '=', 'supplier_products.variant_id')
            ->join('locations', 'locations.id', '=', 'supplier_products.location_id')
            ->where('locations.country', $country)
            ->where('supplier_products.deleted_at', null)
            ->where('variants.deleted_at', null)
            ->select('products.id')->distinct()
        );
    })->when($filters['category'] ?? null, function ($query, $category_id) {
      $query->whereHas('categories', function(Builder $builder) use($category_id) {
        $builder->where('categories.id', $category_id);
      });
    });
  }

  public function categories()
  {
    return $this->belongsToMany(Category::class, 'category_product')->withTimestamps();
  }

  public function variants()
  {
    return $this->hasMany(Variant::class);
  }

  public function supplier_products()
  {
    return $this->hasManyThrough(SupplierProduct::class, Variant::class);
  }

  public function investor($investor_id)
  {
    return $this->morphedByMany(Investor::class, 'productable')->wherePivot('productable_id', $investor_id)->withTimestamps()->withPivot('status');
  }

  public function getGalleryAttribute()
  {
    $tab = [];
    foreach (json_decode($this->attributes['gallery']) as $img) {
      $tab[] = ['url' => Storage::disk('s3')->temporaryUrl($img, now()->addMinutes(240)), 'location' => $img];
    }
    return $tab;
  }

  public function getPhotoAttribute()
  {
    return Storage::disk('s3')->temporaryUrl($this->attributes['photo'], now()->addMinutes(240));
  }

  public function getCreatedAtAttribute($value)
  {
    return  Carbon::parse($value)->diffForHumans();
  }

  public function getUpdatedAtAttribute($value)
  {
    return  Carbon::parse($value)->diffForHumans();
  }

  // public function pricings() : Attribute{
  //   return Attribute::m
  // }
}
