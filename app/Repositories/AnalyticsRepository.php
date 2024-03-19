<?php
namespace App\Repositories;

use Carbon\CarbonPeriod;

class AnalyticsRepository {

  public function top($affiliate, $daterange, $countries) {

    $uploads = $affiliate->orders()->whereBetween('created_at', $daterange)->whereIn('country', $countries)->count();
    $duplicates = $affiliate->orders()->whereBetween('created_at', $daterange)->whereIn('country', $countries)->where('duplicate', 1)->count();
    $wrong_numbers = $affiliate->orders()->whereBetween('created_at', $daterange)->whereIn('country', $countries)->where('status', 'wrong number')->count();
    $rejected = $affiliate->orders()->whereBetween('created_at', $daterange)->whereIn('country', $countries)->where('status', 'rejected')->count();

    $no_answer = $affiliate->orders()->where('status', 'no answer')->whereBetween('no_answer_at', $daterange)->whereIn('country', $countries)->count();
    $confirmed = $affiliate->orders()->whereBetween('confirmed_at', $daterange)->whereIn('country', $countries)->count();
    $cancelled = $affiliate->orders()->whereBetween('cancelled_at', $daterange)->whereIn('country', $countries)->where('status', 'cancelled')->count();
    $shipped   = $affiliate->orders()->whereBetween('delivery_created_at', $daterange)->whereIn('country', $countries)->count();
    $processed = $affiliate->orders()->whereBetween('affected_at',  $daterange)->whereIn('country', $countries)->count();

    $delivered = $affiliate->orders()->whereBetween('confirmed_at', $daterange)->whereIn('country', $countries)->where('status', 'Delivered')->count();
    $returned  = $affiliate->orders()->whereBetween('confirmed_at', $daterange)->whereIn('country', $countries)->where('status', 'Returned')->count();

    return [
      'uploads' => $uploads,
      'duplicates' => $duplicates,
      'wrong_number' => $wrong_numbers,
      'rejected' => $rejected,
      'processed' => $processed,
      'no_answer' => $no_answer,
      'confirmed' => $confirmed,
      'cancelled' => $cancelled,
      'shipped' => $shipped,
      'delivered' => $delivered,
      'returned' => $returned,
      'confirmation_rate' => $this->rate($confirmed, $processed),
      'delivery_rate' => $this->rate($delivered, $confirmed),
      'returned_rate' => $this->rate($returned, $confirmed),
      'daterange' => $daterange,
    ];
  }

  function rate(int $dividend, int $divider)
  {
    $rate = $divider != 0 ? number_format( $dividend/$divider * 100 , 2 ) : 0;
    return "$rate%";
  }

  public function bydayUploads($affiliate, $daterange, $countries) {
    $period = CarbonPeriod::create($daterange[0], $daterange[1]);

    return collect($period)->map(function($day) use($affiliate, $countries) {
    $date = $day->format('Y-m-d');

    $uploaded = $affiliate->orders()->whereDate('created_at', $date)->whereIn('country', $countries)->count();

    $wrong_number = $affiliate->orders()->whereDate('created_at', $date)->where('status', 'wrong number')->whereIn('country', $countries)->count();

    $duplicate = $affiliate->orders()->whereDate('created_at', $date)->where('duplicate', 1)->whereIn('country', $countries)->count();

    $rejected = $affiliate->orders()->whereDate('created_at', $date)->where('status', 'rejected')->whereIn('country', $countries)->count();

    return [
      'day'           => $day->format('Y-m-d'),
      'uploaded'      => $uploaded,
      'wrong_number'  => $wrong_number,
      'duplicate'     => $duplicate,
      'rejected'      => $rejected
    ];

   });
  }

  public function bydayConfirmations($affiliate, $daterange, $countries) {
    $period = CarbonPeriod::create($daterange[0], $daterange[1]);

   return collect($period)->map(function($day) use($affiliate, $countries) {
    $date = $day->format('Y-m-d');


    $confirmed = $affiliate->orders()->whereDate('confirmed_at', $date)->whereIn('country', $countries)->count();

    $processed = $affiliate->orders()->whereDate('affected_at', $date)->whereIn('country', $countries)->count();

    $cancelled = $affiliate->orders()->whereDate('cancelled_at', $date)->whereIn('country', $countries)->count();

    return [
      'day'           => $day->format('Y-m-d'),
      'confirmed'     => $confirmed,
      'processed'     => $processed,
      'cancelled'     => $cancelled,
    ];

   });
  }

  public function bydayDeliveries($affiliate, $daterange, $countries) {
    $period = CarbonPeriod::create($daterange[0], $daterange[1]);

   return collect($period)->map(function($day) use($affiliate, $countries) {
    $date = $day->format('Y-m-d');

    $delivered = $affiliate->orders()->whereDate('confirmed_at', $date)->whereIn('country', $countries)->where('status', 'Delivered')->count();

    $returned = $affiliate->orders()->whereDate('confirmed_at', $date)->whereIn('country', $countries)->where('status', 'Returned')->count();

    return [
      'day'           => $day->format('Y-m-d'),
      'delivered'     => $delivered,
      'returned'      => $returned
    ];

   });

  }
}
