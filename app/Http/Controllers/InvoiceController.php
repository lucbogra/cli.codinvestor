<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
  public function index(){
    return Inertia::render('Invoices/Index', [
      'invoices' => Invoice::paginate(12)
        ->withQueryString()
        ->through(function($invoice){
        return [
          'id' => $invoice->id,
          'slug' => $invoice->slug,
          'date' => date('Y-m-d', strtotime($invoice->created_at)),
          'amount' => $invoice->amount,
          'status' => $invoice->status,
          'paid_date' => $invoice->paid_date,
        ];
      })
    ]);
  }

  public function show($slug){
    $invoice = Invoice::where('slug', $slug)->firstOrFail();
    // dd(collect(json_decode($invoice->datas)->products)->map(function($product){
    //   return [
    //     'product' => Product::withoutTrashed()->find($product->product_id)->select('name', 'sku')->first(),
    //     'amount' => $product->amount,
    //   ];
    // }));
    return Inertia::render('Invoices/Show', [
      'invoice' => [
        'created_at' => date('Y-m-d', strtotime($invoice->created_at)),
        'slug' => $invoice->slug,
        'amount' => $invoice->amount,
        'email' => $invoice->user->investor->email,
        'paid_date' => $invoice->paid_date,
        'payment_method' => $invoice->payment_method,
        'file_url' => $invoice->file_url,
        'products' => collect(json_decode($invoice->datas)->products)->map(function($line){
          $product = Product::withoutTrashed()->findOrfail($line->product_id);
          return [
            'name' => $product->name,
            'sku' => $product->sku,
            'photo' => $product->photo,
            'amount' => $line->amount,
          ];
        }),
      ]
    ]);
  }

  public function invoice_notification($notification_id, $slug){
    request()->user()->unreadNotifications->where('id', $notification_id)->markAsRead();
    return redirect()->route('invoice.show', $slug);
  }

}
