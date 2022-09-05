<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Demofile extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'file'];

  public function getFileAttribute(){
    return Storage::disk('s3')->temporaryUrl($this->attributes['file'], now()->addMinutes(100));
  }
}
