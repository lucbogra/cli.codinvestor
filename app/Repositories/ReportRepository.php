<?php

namespace App\Repositories;

class ReportRepository
{
  public function dataByProducts ($affiliate, $daterange, $countries) {

    return $affiliate->accessProducts()->paginate(10)->withQueryString()->through(function($product) use($affiliate, $daterange, $countries) {

      $uploads = $affiliate->orders()->where('product_id', $product->id)->whereBetween('created_at', $daterange)->whereIn('country', $countries)->count();

      $processed = $affiliate->orders()->where('product_id', $product->id)->whereBetween('affected_at', $daterange)->whereIn('country', $countries)->count();

      $confirmed = $affiliate->orders()->where('product_id', $product->id)->whereBetween('confirmed_at', $daterange)->whereIn('country', $countries)->count();

      $delivered = $affiliate->orders()->where('product_id', $product->id)
                          ->whereBetween('delivered_at', $daterange)
                          ->where('status', 'Delivered')
                          ->whereIn('country', $countries)
                          ->selectRaw("COUNT(*) as number, SUM(commission) as commission")
                          ->first();

      return [
        'name'      => $product->name,
        'sku'       => $product->sku,
        'photo'     => $product->photo,
        'uploaded'   => $uploads,
        'processed' => $processed,
        'confirmed' => $confirmed,
        'delivered' => $delivered->number,
        'commission'    => $delivered->commission
      ];
    });
  }

  public function top ($affiliate, $daterange, $countries) {
    $uploads = $affiliate->orders()->whereBetween('created_at', $daterange)->whereIn('country', $countries)->count();

    $processed = $affiliate->orders()->whereBetween('affected_at', $daterange)->whereIn('country', $countries)->count();

    $confirmed = $affiliate->orders()->whereBetween('confirmed_at', $daterange)->whereIn('country', $countries)->count();

    $delivered = $affiliate->orders()
                  ->whereBetween('delivered_at', $daterange)
                  ->where('status', 'Delivered')
                  ->whereIn('country', $countries)
                  ->selectRaw("COUNT(*) as number, SUM(commission) as commission")
                  ->first();

    return [
      'uploaded' => $uploads,
      'processed' => $processed,
      'confirmed' => $confirmed,
      'delivered' => $delivered->number,
      'commission'    => $delivered->commission
    ];
  }
}
