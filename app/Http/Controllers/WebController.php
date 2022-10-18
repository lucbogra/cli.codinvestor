<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Order;
use App\Models\Pack;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WebController extends Controller
{
  public function plans()
  {
    $packs = Pack::where('active', 1)->get();
    return Inertia::render('Setting/Plans', [
      'packs' => $packs
    ]);
  }

  public function help()
  {
    return Inertia::render('Setting/Help');
  }

  public function createTicket()
  {
    return Inertia::render('Setting/Ticket');
  }

  public function storeTicket(Request $request)
  {
    // return $request->all();
    $request->validate([
      'subject' => 'required',
      'content' => 'required'
    ]);
    $ticket = new Ticket();
    $ticket->user_id = auth()->id();
    $ticket->subject = $request->subject;
    $ticket->content = $request->content;
    $ticket->save();
    return back();
  }

  public function dashboard(Request $request)
  {
    $date = date('Y-m-d');

    if ($request->time == 'today') $date = date('Y-m-d');
    if ($request->time == 'yesterday') $date = date('Y-m-d', strtotime('- 1 days'));
    $investor = Investor::where('user_id', auth()->id())->first();
    $request = $investor->products()->where('status', 'request')->count();
    $denied = $investor->products()->where('status', 'denied')->count();
    $access = $investor->products()->where('status', 'access')->count();

    $uploaded = Order::where('investor_id', auth()->id())->whereDate('created_at', $date)->count();
    $duplicate = Order::where('investor_id', auth()->id())->whereDate('created_at', $date)->duplicate()->count();
    $wrong_number = Order::where('investor_id', auth()->id())->whereDate('created_at', $date)->where('status', 'wrong number')->count();
    $rejected = Order::where('investor_id', auth()->id())->whereDate('created_at', $date)->where('status', 'rejected')->count();
    $confirmed = Order::where('investor_id', auth()->id())->whereDate('confirmed_at', $date)->count();
    $cancelled = Order::cancelled()->where('investor_id', auth()->id())->whereDate('cancelled_at', $date)->get()->count();
    $no_answer = Order::where('status', 'no answer')->whereDate('no_answer_at', $date)->count();
    $confirmed_no_answer = Order::where('investor_id', auth()->id())->where('no_answer_at', '!=', null)->whereDate('no_answer_at', '!=', $date)->where('confirmed_at', $date)->count();
    $delayed = Order::where('investor_id', auth()->id())->whereDate('delayed_at', $date)->where('status', 'delayed')->count();
    $last_5_days_no_answer = Order::where('investor_id', auth()->id())->whereDate('no_answer_at', '>=', date($date, strtotime('-5days')))->where('investor_id', auth()->id())->where('status', 'no answer')->get()->count();
    $confirmed_no_answer_rate = $last_5_days_no_answer ? number_format((float)$confirmed_no_answer * 100 / $last_5_days_no_answer, 2, '.', '') : 0;
    $affected =  Order::where('investor_id', auth()->id())->where('affected_at', $date)->where('reaffected_at', null)->where('investor_id', auth()->id())->where('duplicate', 0)->count();
    $confirmation_rate = $affected != 0 ? number_format((float)$confirmed * 100 / $affected, 2, '.', '') : 0;
    $reaffected = Order::where('investor_id', auth()->id())->whereDate('reaffected_at', $date)->count();
    $aov = $confirmed != 0 ?
      number_format((float)Order::where('investor_id', auth()->id())->where('confirmed_at', $date)->sum('codprice') / $confirmed, 2, '.', '') : 0;

    return Inertia::render('Dashboard', [
      'uploaded' => $uploaded,
      'duplicate' => $duplicate,
      'wrong_number' => $wrong_number,
      'rejected' => $rejected,
      'confirmed' => $confirmed,
      'cancelled' => $cancelled,
      'no_answer' => $no_answer,
      'delayed' => $delayed,
      'confirmed_no_answer' => $confirmed_no_answer,
      'confirmed_no_answer_rate' => $confirmed_no_answer_rate,
      'affected' => $affected,
      'confirmation_rate' => $confirmation_rate,
      'reaffected' => $reaffected,
      'aov' => $aov,
      'request' => $request,
      'denied' => $denied,
      'access' => $access
    ]);
  }

  public function performance()
  {
    // if ($param == 30) {
    for ($i = 29; $i >= 0; $i--) {
      $d[date("Y-m-d", strtotime('-' . $i . ' days'))] = date("m-d", strtotime('-' . $i . ' days'));
    }

    $datas = collect($d)->map(function ($day, $key) {
      $affected = Order::where('investor_id', auth()->id())->whereDate('affected_at', $key)->where('duplicate', 0)->count();
      return  $affected != 0 ? number_format((float)Order::whereDate('confirmed_at', $key)->count() * 100 / $affected, 2, '.', '') : 0;
    });

    return response()->json($datas);
  }
}
