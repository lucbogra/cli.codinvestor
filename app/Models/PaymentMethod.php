<?php

namespace App\Models;

use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
  use HasFactory;

  protected $fillable = ['user_id', 'datas', 'datas->default', 'datas->bank_account', 'datas->maroccan_bank_account', 'datas->payoneer', 'datas->paypal', 'datas->transferwise'];

  protected static function booted()
  {
    static::addGlobalScope(new UserScope);
  }
}
