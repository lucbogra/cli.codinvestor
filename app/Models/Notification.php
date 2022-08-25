<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use HasFactory;

    protected $table = "notifications";

    public function getCreatedAtAttribute($value) {
        return  Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value) {
        return  Carbon::parse($value)->diffForHumans();
    }
}
