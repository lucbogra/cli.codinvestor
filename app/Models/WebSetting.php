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

    public function getIconAttribute(){
      return Storage::disk('s3')->temporaryUrl($this->attributes['icon'], now()->addMinutes(10));
    }

    public function getLogoAttribute(){
      return Storage::disk('s3')->temporaryUrl($this->attributes['logo'], now()->addMinutes(10));
    }

}
