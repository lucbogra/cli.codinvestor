<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Translatable\HasTranslations;

class Pricing extends Model
{
    use HasFactory;
    use SoftDeletes;
    // use HasTranslations;

    public $translatable = ['libelle'];

    protected $fillable = ['service_id','libelle', 'amount', 'active'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
      return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function packs(){
      return $this->belongsToMany(Pack::class)->withTimestamps();
    }

    public function service(){
      return $this->belongsTo(Service::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('libelle', 'like', '%' . $search . '%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
