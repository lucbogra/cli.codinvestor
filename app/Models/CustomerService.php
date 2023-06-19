<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    use HasFactory;

    protected $table='customer_service';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accountManager()
    {
        return $this->belongsTo(User::class,'account_manager_id');
    }

    public function customerService()
    {
        return $this->belongsTo(User::class,'customer_service_id');
    }
}
