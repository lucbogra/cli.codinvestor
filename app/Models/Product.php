<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'photo',
        'description',
        'gallery',
        'active',
        'link',
        'user_id'
    ];
    protected $casts = [
        'gallery' => 'array',
    ];

    protected $dates = [
    'created_at',
    'updated_at',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }


    public function getGalleryAttribute()
    {
        $tab = [];
        foreach (json_decode($this->attributes['gallery']) as $img) {
            $tab[] = ['url' => Storage::disk('s3')->temporaryUrl($img, now()->addMinutes(10)), 'location' => $img];
        }
        return $tab;
    }

    public function getPhotoAttribute()
    {
        return Storage::disk('s3')->temporaryUrl($this->attributes['photo'], now()->addMinutes(10));
    }

    public function getCreatedAtAttribute($value) {
        return  Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value) {
        return  Carbon::parse($value)->diffForHumans();
    }
}
