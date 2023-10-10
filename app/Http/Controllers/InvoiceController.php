<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PDF;

class InvoiceController extends Controller
{
  public function index(){
    // $pdf = Pdf::loadView('Invoice');
    // return $pdf->download('invoice.pdf');

    return Inertia::render('Invoices/Index',[
      'invoices' => InvoiceResource::collection(Invoice::with('invoiceable')->orderBy('created_at', 'DESC')->paginate(20))
    ]);
  }

  public function show(Invoice $invoice){
    $invoice = new InvoiceResource($invoice->loadMissing('invoiceable', 'fundings','integrationPayments.integration'));
    return Inertia::render('Invoices/Show', compact('invoice'));
  }

  public function invoice_notification($notification_id, $slug){
    request()->user()->unreadNotifications->where('id', $notification_id)->markAsRead();
    return redirect()->route('invoice.show', $slug);
  }

  public function download(Invoice $invoice){
    $invoice = json_encode(new InvoiceResource($invoice->loadMissing('invoiceable', 'fundings','integrationPayments')));
    $invoice = json_decode( $invoice);
    $pdf = PDF::loadView('Invoice', compact('invoice'));
    return $pdf->download('invoice#-'.$invoice->slug.'.pdf');
  }

}
