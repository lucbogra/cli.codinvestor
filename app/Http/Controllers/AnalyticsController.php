<?php

namespace App\Http\Controllers;

use App\Actions\GetCountries;
use App\Actions\GetDateRange;
use App\Models\Location;
use App\Repositories\AnalyticsRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnalyticsController extends Controller
{
  private $affiliate;
  private $daterange;
  private $countries;
  private $analyticsRepository;

  public function __construct(GetDateRange $daterange, GetCountries $countries, AnalyticsRepository $analyticsRepository)
  {
    $this->middleware(function ($request, $next) {
      $this->affiliate = $request->user()->hasRole('Investor') ? $request->user()->investor : ($request->user()->hasRole('Member') ? $request->user()->member->investor : null);
      return $next($request);
  });

    $this->daterange = $daterange->action();
    $this->countries = $countries->execute();
    $this->analyticsRepository = $analyticsRepository;
  }

  public function index()
  {
    return Inertia::render('Analytics/Index', [
      'daterange' => $this->daterange,
      'countries' => $this->countries,
    ]);
  }

  public function top()
  {
    $data = $this->analyticsRepository->top($this->affiliate, $this->daterange, $this->countries);

    return response()->json($data);
  }

  public function byday()
  {
    $data = $this->analyticsRepository->byDayData($this->affiliate, $this->daterange, $this->countries);

    return response()->json($data);
  }

  public function uploads()
  {
    $data = $this->analyticsRepository->bydayUploads($this->affiliate, $this->daterange, $this->countries);

    return response()->json($data);
  }

  public function confirmations()
  {
    $data = $this->analyticsRepository->bydayConfirmations($this->affiliate, $this->daterange, $this->countries);

    return response()->json($data);
  }

  public function deliveries()
  {
    $data = $this->analyticsRepository->bydayDeliveries($this->affiliate, $this->daterange, $this->countries);

    return response()->json($data);
  }
}
