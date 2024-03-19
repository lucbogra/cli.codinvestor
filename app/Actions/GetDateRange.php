<?php
namespace App\Actions;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class GetDateRange
{
  public function action()
  {
    $daterange = Request::get('daterange') ?
      [Carbon::parse(Request::get('daterange')[0])->startOfDay(), Carbon::parse(Request::get('daterange')[1])->endOfDay()] :
      [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()];
    return $daterange;
  }
}
