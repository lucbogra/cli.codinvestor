<?php
namespace App\Actions;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class GetDateRange
{
  public function action()
  {
    $daterange = Request::get('daterange') ?? [Carbon::now()->startOfMonth()->format('Y-m-d'), date('Y-m-d')];
    if ($daterange[0] == $daterange[1]){
      $daterange[1] = Carbon::parse($daterange[0])->endOfDay();
    }

    return $daterange;
  }
}
