<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Integration extends Model
{
    use HasFactory;

    public function getLogoAttribute(){
      return Storage::disk('s3')->temporaryUrl($this->attributes['logo'], now()->addMinutes(100));
    }
}
