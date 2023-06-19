<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        // 'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function password() : Attribute
    {
      return Attribute::make(
        set : fn ($value) => Hash::needsRehash($value) ? Hash::make($value) : $value
      );
    }

    public function investor(){
      return $this->hasOne(Investor::class);
    }

    public function member(){
      return $this->hasOne(Member::class);
    }

    public function messages()
    {
      return $this->belongsToMany(Message::class, 'user_message')->withPivot('read_at');
    }

    public function getRoleAttribute(){
      return $this->getRoleNames()->first();
    }

    // public function getProfilePhotoUrlAttribute($value) {
    //     return (is_null($value)) ? 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', $this->name)
    //             : Storage::disk('s3')->temporaryUrl($this->attributes['profile_photo_url'], now()->addMinutes(10));
    // }

    public function getStepAttribute(){
      // return $this->attributes['registration_steps'] !== null ? collect(json_decode($this->attributes['registration_steps'])->steps)->where('status', 'current')->first() : null;
      return json_decode($this->attributes['registration_steps'])?->current;

    }

    public function getStepStatusAttribute(){
      return json_decode($this->attributes['registration_steps'])?->finished;
    }

    public function customerService()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function accountManager()
    {
        return $this->hasOne(User::class, 'agent_id');
    }

    public function customerServices()
    {
        return $this->hasOne(CustomerService::class, 'user_id');
    }

}
