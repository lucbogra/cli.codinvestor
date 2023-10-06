<?php

namespace App\Models;

use App\Models\Scopes\IntegrationScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegrationPayment extends Model
{
    use HasFactory;

    // protected $table='integration_payments';
    protected $fillable=[
        'integration_id',
        'integrable_type',
        'integrable_id',
        'amount',
        'withdraw',
        'invoice_id',
        'payment_info',
        'status'
    ];

    public function integrablePayment()
    {
        return $this->morphTo();
    }

    public function getRemainAttribute()
    {
        return $this->attributes['amount'] - $this->belongsToMany(Invoice::class, 'integration_payment_invoice')->withPivot('amount_paid')->sum('amount_paid');
    }

    public function integrationInvoices()
    {
        return $this->belongsToMany(Invoice::class, 'integration_payment_invoice','integration_payment_id','invoice_id');
    }

    public function integration()
    {
        return $this->belongsTo(Integration::class,'integration_id')->withoutGlobalScope(IntegrationScope::class);
    }

}
