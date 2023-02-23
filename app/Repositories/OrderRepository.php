<?php

namespace App\Repositories;

use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderRepository
{
  public function history($daterange)
  {
    return OrderResource::collection(Order::whereBetween('created_at', $daterange)->get())->groupBy('status');
  }
}
