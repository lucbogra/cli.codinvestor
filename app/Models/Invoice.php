<?php

namespace App\Models;

use App\Scopes\InvoiceScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Invoice extends Model
{
  use HasFactory;

  protected static function booted()
  {
    static::addGlobalScope(new InvoiceScope);
  }
  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function invoiceable()
  {
    return $this->morphTo();
  }

  public function fundings()
  {
    return $this->belongsToMany(Funding::class, 'funding_invoice')->withPivot('amount_paid');
  }

  public function integrationPayments()
  {
    return $this->belongsToMany(IntegrationPayment::class, 'integration_payment_invoice')->withPivot('amount_paid');
  }

  public function getFileUrlAttribute(){
    return $this->attributes['file_url'] ? Storage::disk('s3')->temporaryUrl($this->attributes['file_url'], now()->addMinutes(600)) : null;
  }
}
