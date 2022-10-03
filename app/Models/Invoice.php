<?php

namespace App\Models;

use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Invoice extends Model
{
  use HasFactory;

  protected static function booted()
  {
    static::addGlobalScope(new UserScope);
  }
  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function user(){
    return $this->belongsTo(User::class);
  }

  public function getFileUrlAttribute(){
    return $this->attributes['file_url'] ? Storage::disk('s3')->temporaryUrl($this->attributes['file_url'], now()->addMinutes(600)) : null;
  }
}
