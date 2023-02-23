<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  use HasFactory;
  protected $fillable = ['read_at'];

  public function users()
  {
    return $this->belongsToMany(User::class, 'user_message')->withPivot('read_at');
  }

  public function getRouteKeyName()
  {
    return 'slug';
  }
}
