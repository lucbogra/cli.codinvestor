<?php

namespace App\Http\Controllers;

use App\Imports\OrderImport;
use App\Models\Demofile;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class OrderController extends Controller
{
  public function orders()
  {
    return Inertia::render('Orders/Index', [
      'demo_file' => Demofile::where('name', 'Import Format')->first()->file,
      'orders' => Order::whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'DESC')->get()->map(function ($order) {
        return [
          'id' => $order->id,
          'duplicate' => $order->duplicate,
          'created_at' => $order->created_at,
          'customer_name' => $order->customer_name,
          'phone' => $order->phone,
          'country' => $order->country,
          'customer_city' => $order->customer_city,
          'customer_region' => $order->customer_region,
          'customer_address' => $order->customer_address,
          'product_name' => $order->product_name,
          'price' => $order->price,
          'website' => $order->website,
          'status' => $order->status,
          'product_link' => $order->product_link,
          'note' => $order->note,
        ];
      }),
    ]);
  }

  public function import(Request $request)
  {
    $request->validate([
      'file' => ['required', 'mimes:xlsx,xlsm,xlsb,xltx,xls,csv'],
    ]);

    (new OrderImport(auth()->user()->investor->id))->import($request->file('file'));
    return redirect()->route('orders.index');

  }
}
