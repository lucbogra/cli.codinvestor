<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'investor_id', 'type', 'status'];

    public function websites()
    {
      return $this->hasMany(Website::class);
    }

    public function teams()
    {
      return $this->hasMany(Team::class);
    }

    public function projectable()
    {
      return $this->morphTo();
    }

}
