<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class WebController extends Controller
{
    public function setting() {
        return Inertia::render('Setting/Index');
    }
}
