<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Variant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'sku',
        'pu',
        'description',
        'color',
        'size',
        'genre',
        'active',
        'photo',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouses()
    {
      return $this->belongsToMany(Warehouse::class)->withTimestamps()->withPivot('qty');
    }

    public function histories()
    {
      return $this->hasMany(ProductHistory::class);
    }

    public function getPhotoAttribute(){
      return Storage::disk('s3')->temporaryUrl($this->attributes['photo'], now()->addMinutes(10));
    }

    public function getPhotoLocationAttribute(){
      return $this->attributes['photo'];
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('sku', 'like', '%' . $search . '%')
                  ->orWhere('color', 'like', '%' . $search . '%')
                  ->orWhere('genre', 'like', '%' . $search . '%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
