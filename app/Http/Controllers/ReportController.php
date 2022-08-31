<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Order;
use App\Models\ScheduledReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
  public function reports(){
    $start = Request::get('start') ? Request::get('start') : date("Y-m-d", strtotime('- 29 days'));
    $end = Request::get('end') ? Request::get('end') : date("Y-m-d");

    return  Inertia::render('Reports/Index', [
      'dates' => (object)[
        'start' => $start,
        'end' => $end,
        'max' => date("Y-m-d"),
      ],
    ]);
  }

  public function performance($start, $end){
    $id = auth()->user()->investor->id;

    $datas = ScheduledReport::whereBetween('date', [$start, $end])->get()->map(function ($item) use($id) {
      $values = json_decode($item->datas, ',');
      return [
        'date' => date('m-d', strtotime($item->date)),
        'uploaded' => collect($values)->where('id', $id)->sum('uploaded'),
        'duplicate' => collect($values)->where('id', $id)->sum('duplicate'),
        'wrong_number' => collect($values)->where('id', $id)->sum('wrong_number'),
        'rejected' => collect($values)->where('id', $id)->sum('rejected'),
        'affected' => collect($values)->where('id', $id)->sum('affected'),
        'confirmed' => collect($values)->where('id', $id)->sum(function ($data) {
          return $data['confirmed']['number'];
        }),
        'confirmed_sum' => collect($values)->where('id', $id)->sum(function ($data) {
          return $data['confirmed']['sumprice'];
        }),
        'cancelled' => collect($values)->where('id', $id)->sum('cancelled'),
      ];
    });

    $affected = $datas->sum('affected');
    $confirmed = $datas->sum('confirmed');
    $confirmed_sum = $datas->sum('confirmed_sum');
    $cross = $datas->sum('cross');
    $delivered = Order::whereBetween('delivered_at', [$start, $end])->where('investor_id', $id)->selectRaw('count(delivered_at) as number, sum(codprice) as sumprice')->first();
    $returned = Order::whereBetween('returned_at', [$start, $end])->where('investor_id', $id)->count();
    $delivery_created = Order::whereBetween('delivery_created_at', [$start, $end])->where('investor_id', $id)->count();

    return response()->json([
      'datas' => $datas,
      'uploaded' => $datas->sum('uploaded'),
      'duplicate' => $datas->sum('duplicate'),
      'wrong_number' => $datas->sum('wrong_number'),
      'rejected' => $datas->sum('rejected'),
      'confirmed' => $confirmed,
      'cancelled' => $datas->sum('cancelled'),
      'affected' => $datas->sum('affected'),
      'delivered' => $delivered->number,
      'returned' => $returned,
      'confirmation_rate' => $affected != 0 ? number_format((float)$confirmed * 100 / $affected, 2, '.', '') : 0,
      'delivery_rate' => $delivery_created != 0 ? number_format((float)$delivered->number * 100 / $delivery_created, 2, '.', '') : 0,
      'returned_rate' => $delivery_created != 0 ? number_format((float)$returned * 100 / $delivery_created, 2, '.', '') : 0,
    ]);
  }
}
