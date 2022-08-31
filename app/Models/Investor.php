<?php

namespace App\Models;

use App\Scopes\InvestorScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Investor extends Model
{
    use HasFactory;
    use SoftDeletes, Notifiable;

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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->hasOne(Project::class);
    }

    public function manager(){
      return $this->belongsTo(User::class, 'manager_id');
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

    protected static function booted()
    {
      static::addGlobalScope(new InvestorScope);
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
      return $this->belongsToMany(Product::class, 'investor_product','investor_id','product_id')->withPivot('status', 'link')->withTimestamps();
    }

    public function request_state($status){
      return $this->belongsToMany(Product::class, 'investor_product','investor_id','product_id')->wherePivot('status', $status);
    }

    public function has_requested($product_id){
      return $this->belongsToMany(Product::class, 'investor_product','investor_id','product_id')->wherePivot('product_id', $product_id);
    }
}
