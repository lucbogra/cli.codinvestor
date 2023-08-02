<?php

namespace App\Http\Controllers;

use App\Actions\GetDateRange;
use App\Imports\OrderImport;
use App\Models\Demofile;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class OrderController extends Controller
{
  protected  $investor;
  public $daterange;
  public $order_repository;

  public function __construct(GetDateRange $daterange, OrderRepository $order_repository)
  {
    $this->middleware(function ($request, $next) {
      $this->investor = $request->user()->hasRole('Investor') ? $request->user()->investor : ($request->user()->hasRole('Member') ? $request->user()->member->investor : null);
      return $next($request);
    });
    $this->daterange = $daterange;
    $this->order_repository = $order_repository;
  }

  public function orders()
  {
    return Inertia::render('Orders/Index', [
      'demo_file' => Demofile::where('name', 'Import Format')->first()->file,
      'orders' => Order::whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'DESC')->get()->map(function ($order) {
        return [
          'id' => $order->id,
          'duplicate' => $order->duplicate,
          'created_at' => Carbon::parse($order->created_at)->diffForHumans(),
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
    $count = $this->investor->accessProducts()->wherePivot('commission_type', null)->count();
    if($count > 0){
      return back()->with('error', 'please update your products pricings !'.$count.' products left');
    }

    $request->validate([
      'file' => ['required', 'mimes:xlsx,xlsm,xlsb,xltx,xls,csv'],
    ]);

    (new OrderImport($this->investor->id))->import($request->file('file'));
    return redirect()->route('orders.index')->with('success', 'Orders uploaded successfully.');

  }

  public function history()
  {
    $daterange = $this->daterange->action();
    // return $daterange;
    return Inertia::render('Orders/History', [
      'daterange' => $daterange,
      'orders' =>  $this->order_repository->history($daterange)
    ]);
  }

  public function uploaded()
  {
    $daterange = $this->daterange->action();
    return $this->order_repository->history($daterange);
  }
}
