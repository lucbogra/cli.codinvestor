<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

    public function investor()
  {
    return $this->belongsTo(Investor::class);
  }



  public function getDeliveredAtAttribute()
  {
    return date('d-m-Y', strtotime($this->attributes['delivered_at']));
  }

  public function scopeOrderByCreatedAt($query)
  {
    $query->orderBy('created_at', 'desc');
  }

  public function scopeAgent($query, $id)
  {
    $query->where('agent_id', $id);
  }

  public function scopeSup($query, $id)
  {
    $query->where('sup_id', $id);
  }

  public function scopeUploaded($query)
  {
    $query->where('status', 'pending')->where('agent_id', null);
  }

  public function scopePending($query)
  {
    $query->where('status', 'pending')->where('agent_id', '!=', null);
  }

  public function scopePendingAndNoAnswer($query)
  {
    $query->where('status', 'pending')->where('agent_id', '!=', null)->orWhere('status', 'no answer')->where('no_answer_at', '>=', date('Y-m-d', strtotime('-7days')));
  }

  public function scopeOldNoAnswer($query)
  {
    $query->whereIn('status', ['no answer', 'closed'])->whereDate('no_answer_at', '<', date('Y-m-d', strtotime('-7days')))->whereDate('no_answer_at', '>', date('Y-m-d', strtotime('-30days')));
  }


  public function scopeConfirmed($query)
  {
    $query->where('status', 'confirmed');
  }

  public function scopeCancelled($query)
  {
    $query->where('status', 'cancelled');
  }

  public function scopeNoAnswer($query)
  {
    $query->where('status', 'no answer')->whereDate('no_answer_at', '<', date('Y-m-d'));
  }

  public function scopeDelayed($query)
  {
    $query->where('status', 'delayed');
  }

  public function scopeDelivered($query)
  {
    $query->where('status', 'delivered');
  }

  public function scopeDeliveryInProgress($query)
  {
    $query->where('status', 'Delivery In Progress');
  }

  public function scopeDuplicate($query)
  {
    $query->where('duplicate', 1);
  }

  public function scopeClosed($query)
  {
    $query->where('status', 'closed');
  }

  public function scopeWrongNumber($query)
  {
    $query->where('status', 'wrong number');
  }

  public function scopeReturned($query)
  {
    $query->where('status', 'returned');
  }

  public function scopeUnprocessed($query)
  {
    $query->where('status', 'pending')->orWhere(function (Builder $query) {
      $query->where('status', 'no answer')->where('no_answer_at', date('Y-m-d'));
    })->orWhere('status', 'wrong number');
  }

  public function scopeFilter($query, array $filters)
  {
    $query->when($filters['search'] ?? null, function ($query, $search) {
      $query->where(function ($query) use ($search) {
        $query->where('ref', 'like', '%' . $search . '%')
          ->orWhere('status', 'like', '%' . $search . '%')
          ->orWhere('customer_name', 'like', '%' . $search . '%')
          ->orWhere('customer_city', 'like', '%' . $search . '%')
          ->orWhere('codprice', 'like', '%' . $search . '%');
      });
    })->when($filters['status'] ?? null, function ($query, $status) {
      $query->where('status', $status);
    })->when($filters['trashed'] ?? null, function ($query, $trashed) {
      if ($trashed === 'with') {
        $query->withTrashed();
      } elseif ($trashed === 'only') {
        $query->onlyTrashed();
      }
    })->when($filters['date'] ?? null, function ($query, $date) {
      $query->whereDate('confirmed_at', $date);
    });
  }

}
