<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'ref', 'customer_name', 'phone', 'customer_city', 'product_name', 'country', 'website', 'price',
        'investor_id', 'user_id', 'agent_id', 'affected_at', 'customer_id', 'platform', 'customer_region', 'customer_address',
        'codprice', 'status', 'warehouse_id', 'confirmed_at', 'cancelled_at', 'cancel_reason', 'no_answer_at', 'delayed_at',
        'delayed_date', 'delivered_at', 'delayed_date', 'delivered_at', 'returned_at', 'closed_at', 'duplicate', 'note',
        'affected_at', 'tries', 'reaffected_at', 'product_link', 'can_affect', 'tracking_number', 'delivery_status', 'order_number', 'last_mile', 'shiper'
      ];


    public function getCreatedAtAttribute($value) {
        return  Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value) {
        return  Carbon::parse($value)->diffForHumans();
    }
}
