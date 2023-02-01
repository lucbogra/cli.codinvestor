<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
  public function index(){
    return Inertia::render('Invoices/Index',[
      'invoices' => InvoiceResource::collection(Invoice::with('invoiceable')->orderBy('created_at', 'DESC')->paginate(20))
    ]);
  }

  public function show(Invoice $invoice){
    $invoice = new InvoiceResource($invoice->loadMissing('invoiceable', 'fundings'));
    return Inertia::render('Invoices/Show', compact('invoice'));
  }

  public function invoice_notification($notification_id, $slug){
    request()->user()->unreadNotifications->where('id', $notification_id)->markAsRead();
    return redirect()->route('invoice.show', $slug);
  }

}
