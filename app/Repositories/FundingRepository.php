<?php

namespace App\Repositories;

use App\Http\Resources\FundingResource;
use App\Models\Funding;

class FundingRepository
{
  public function all()
  {
    return FundingResource::collection(Funding::all());
  }
}
