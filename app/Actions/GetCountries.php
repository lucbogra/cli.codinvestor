<?php
namespace App\Actions;

use App\Models\Location;
use Illuminate\Support\Facades\Request;

class GetCountries
{
  public function execute()
  {
    return Request::get('countries') ?? Location::select('country')->get()->pluck('country');
  }
}
