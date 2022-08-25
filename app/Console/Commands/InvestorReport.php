<?php

namespace App\Console\Commands;

use App\Models\Investor;
use App\Models\Order;
use App\Models\ScheduledReport;
use App\Scopes\InvestorScope;
use Illuminate\Console\Command;

class InvestorReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investor:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automacaly calculate investors daily reports';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $date = date('Y-m-d');

        $investors = Investor::WithoutGlobalScope(InvestorScope::class)->select('id','first_name', 'last_name', 'manager_id')->get()->map(function ($investor) use($date){
        $uploaded = Order::whereDate('created_at', $date)->where('investor_id', auth()->id())->count();
        $duplicate = Order::whereDate('created_at', $date)->where('investor_id', auth()->id())->duplicate()->count();
        $wrong_number = Order::whereDate('created_at', $date)->where('investor_id', auth()->id())->where('status', 'wrong number')->count();
        $rejected = Order::whereDate('created_at', $date)->where('investor_id', auth()->id())->where('status', 'rejected')->count();
        // $confirmed = Order::whereDate('confirmed_at', $date)->where('investor_id', auth()->id())->count();
        $confirmed = Order::whereDate('confirmed_at', $date)->where('investor_id', auth()->id())->selectRaw('count(confirmed_at) as number, sum(codprice) as sumprice')->first();
        // $delivered = Order::where('status', 'Delivered')->whereDate('delivered_at', $date)->where('investor_id', auth()->id())->selectRaw('count(delivered_at) as number, sum(codprice) as sumprice')->first();
        $cancelled = Order::cancelled()->whereDate('cancelled_at', $date)->where('investor_id', auth()->id())->get()->count();
        $no_answer = Order::where('status', 'no answer')->whereDate('no_answer_at', $date)->where('investor_id', auth()->id())->count();
        $affected =  Order::where('affected_at', $date)->where('reaffected_at', null)->where('investor_id', auth()->id())->where('duplicate', 0)->count();
        $delayed = Order::whereDate('delayed_at', $date)->where('status', 'delayed')->where('investor_id', auth()->id())->count();
        // $aov = $confirmed->number != 0 ? number_format((float)$confirmed->sumprice / $confirmed->number, 2, '.', '') : 0;
        // $returned = Order::whereDate('returned_at', $date)->where('status', 'Returned')->where('investor_id', auth()->id())->count();
        $cross = Order::where('confirmed_at', $date)->where('investor_id', auth()->id())->get()->map(function ($item) {
          return [
            'cross' => $item->orderlines->count() > 1 ? 1 : 0,
          ];
        })->sum('cross');

        return[
          'uploaded' => $uploaded,
          'duplicate' => $duplicate,
          'wrong_number' => $wrong_number,
          'rejected' => $rejected,
          'confirmed' => $confirmed,
          'cancelled' => $cancelled,
          'no_answer' => $no_answer,
          'affected' => $affected,
          'delayed' => $delayed,
          'cross' => $cross,
        ];
      });

      $object = ScheduledReport::where('date', $date)->first();
      if($object == null){
        ScheduledReport::create([
          'date' => $date,
          'datas' => json_encode($investors)
        ]);
      }else{
        $object->update([
          'date' => $date,
          'datas' => json_encode($investors)
        ]);
      }
      $this->info('Successfully update reports');

    }
}
