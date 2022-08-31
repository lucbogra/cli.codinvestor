<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class WebSetting extends Model
{
    use HasFactory;

    public function getLogoWhiteAttribute(){
      return Storage::disk('s3')->temporaryUrl($this->attributes['logo_white'], now()->addMinutes(300));
    }

}
