<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Translatable\HasTranslations;

class Pack extends Model
{
    use HasFactory;
    use SoftDeletes;
    // use HasTranslations;

    public $translatable = ['name', 'description', 'price', 'features'];

    protected $fillable = ['name', 'description', 'price', 'permissions', 'active', 'features'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
      return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function pricings() {
      return $this->belongsToMany(Pricing::class)->withTimestamps();
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
}
