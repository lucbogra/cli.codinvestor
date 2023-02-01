<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
  public function index() {
    return Inertia::render('Services/Index', [
      'services' => ServiceResource::collection(Service::all())
    ]);
  }
}
