<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integrable extends Model
{
    use HasFactory;

    protected $fillable=[
        'integration_id',
        'integrable_type',
        'integrable_id',
        'token',
        'connected'
    ];

    public function integration()
    {
        return $this->belongsTo(Integration::class);
    }

}
