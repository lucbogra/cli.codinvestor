<?php

namespace App\Http\Controllers;

use App\Models\ScheduledReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DashboardController extends Controller
{
  public function index(){

    // dd(array_rand( User::role('Account Manager')->where('active', 1)->get()->toArray()));
    if(request()->user()->hasRole('Member')){
      return Redirect::route('marketplace.index');
    }
    return Inertia::render('Dashboard/Index');
  }

  public function top($time){
    if ($time == 'today') $date = date('Y-m-d');
    if ($time == 'yesterday') $date = date('Y-m-d', strtotime('- 1 days'));
    $id = auth()->user()->investor->id;

    $datas = ScheduledReport::where('date', $date)->first();
    if($datas == null){return null;}
    $datas = json_decode($datas->datas, ',');

    if($datas == null){return null;}
    $confirmed_number = collect($datas)->where('id', $id)->sum(function ($data) {
      return $data['confirmed']['number'];
    });
    $confirmed_sum = collect($datas)->where('id', $id)->sum(function ($data) {
      return $data['confirmed']['sumprice'];
    });
    $affected = collect($datas)->where('id', $id)->sum('affected');
    return response()->json([
      'uploaded' => collect($datas)->where('id', $id)->sum('uploaded'),
      'duplicate' => collect($datas)->where('id', $id)->sum('duplicate'),
      'wrong_number' => collect($datas)->where('id', $id)->sum('wrong_number'),
      'rejected' => collect($datas)->where('id', $id)->sum('rejected'),
      'confirmed' => $confirmed_number,
      'cancelled' => collect($datas)->where('id', $id)->sum('cancelled'),
      'no_answer' => collect($datas)->where('id', $id)->sum('no_answer'),
      'affected' => $affected,
      'delayed' => collect($datas)->where('id', $id)->sum('delayed'),
      'confirmation_rate' => $affected != 0 ? number_format((float)$confirmed_number * 100 / $affected, 2, ',', '') : 0,
    ]);
  }

  public function performance(){

    $end = date('Y-m-d');
    $start = date("Y-m-d", strtotime('- 30 days'));
    $id = auth()->user()->investor->id;

    $confirmation_chart = ScheduledReport::whereBetween('date', [$start, $end])->get()->map(function ($item) use($id){
      $datas = json_decode($item->datas, ',');
      $uploaded = collect($datas)->where('id', $id)->sum('uploaded');
      $affected = collect($datas)->where('id', $id)->sum('affected');
      $confirmed = collect($datas)->where('id', $id)->sum(function ($data) {
        return $data['confirmed']['number'];
      });

      return  [
        'date' => date('m-d', strtotime($item->date)),
        'uploaded' => $uploaded,
        'affected' => $affected,
        'confirmed' => $confirmed,
        'confirmation_rate' => $affected != 0 ?
          number_format((float)$confirmed * 100 / $affected, 2, '.', '') : 0];
    });

    return response()->json($confirmation_chart);

  }

  public function month_reports(){
    $date = Carbon::now();
    $start = $date->startOfMonth()->format('Y-m-d');
    $end = $date->endOfMonth()->format('Y-m-d');
    $id = auth()->user()->investor->id;

    return response()->json(
      ScheduledReport::whereBetween('date', [$start, $end])->get()->map(function($day) use($id) {
        $values = json_decode($day->datas, ',');
        return [
          'uploaded' => collect($values)->where('id', $id)->sum('uploaded'),
          'affected' => collect($values)->where('id', $id)->sum('affected'),
          'confirmed' => collect($values)->where('id', $id)->sum(function ($data) {
            return $data['confirmed']['number'];
          })
        ];
    }));

  }
}
