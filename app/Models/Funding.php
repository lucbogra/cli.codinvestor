<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Funding extends Model
{
  use HasFactory;

  public function getFileAttribute(){
    return $this->attributes['file'] ? Storage::disk('s3')->temporaryUrl($this->attributes['file'], now()->addMinutes(600)) : null;
  }

  public function getRemainAttribute()
  {
    return $this->attributes['amount'] - $this->belongsToMany(Invoice::class, 'funding_invoice')->withPivot('amount_paid')->sum('amount_paid');
  }

  public function invoices()
  {
    return $this->belongsToMany(Invoice::class, 'funding_invoice')->withPivot('amount_paid');
  }

  protected static function booted()
  {
    static::addGlobalScope('my_fundings', function (Builder $builder) {
      $builder->where('affiliate_id', auth()->user()->investor->id);
    });
  }
}
