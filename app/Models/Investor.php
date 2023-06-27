<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class Investor extends Model
{
    use HasFactory;
    use SoftDeletes, Notifiable , HasApiTokens;

    protected $fillable = [
      'first_name',
      'last_name',
      'email',
      'phone',
      'address',
      'city',
      'state',
      'zip',
      'country',
      'company',
      'title',
      'website',
      'user_id',
      'manager_id',
      'responses',
      'cin',
      'seller_status',
      'seller_request_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
      return $this->morphOne(Project::class, 'projectable')->withTrashed();
    }

    public function manager(){
      return $this->belongsTo(User::class, 'manager_id');
    }

    public function members()
    {
      return $this->hasMany(Member::class, 'affiliate_id');
    }

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('last_name')->orderBy('first_name');
    }

    public function getLocationAttribute()
    {
        return $this->city.', '.$this->state;
    }

     /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

    public function products(){
      return $this->morphToMany(Product::class, 'productable')->withTimestamps()->withPivot('status', 'link', 'affiliate_commission', 'affiliate_price')->where('active', true)->withTimestamps();
    }

    public function accessProducts(){
      return $this->morphToMany(Product::class, 'productable')->wherePivot('status', 'access')->withPivot('status', 'link', 'affiliate_commission', 'affiliate_price')->withTimestamps();
    }

    public function request_state($status){
      return $this->morphToMany(Product::class, 'productable')->wherePivot('status', $status);
    }

    public function has_requested($product_id){
      return $this->morphToMany(Product::class, 'productable')->wherePivot('product_id', $product_id);
    }

    public function balance_histories(){
      return $this->hasMany(BalanceHistory::class)->where('withdrawn', 0);
    }

    public function integrations()
    {
      return $this->morphToMany(Integration::class, 'integrable')
                  ->withPivot('created_at', 'connected');
    }

    public function integrationsPayment()
    {
      return $this->morphMany(IntegrationPayment::class, 'integrable');
    }

    public function not_withdrawn_integration_payments(){
      return $this->morphMany(IntegrationPayment::class, 'integrable')->where('withdrawn', false);
    }

    public function pendingIntegrationPayment()
    {
      return $this->hasMany(IntegrationPayment::class, 'integrable_id')->where('status','!=','paid');
    }
    
}
