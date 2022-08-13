<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WebController extends Controller
{
    public function plans() {
        $packs = Pack::where('active', 1)->get();
        return Inertia::render('Setting/Plans', [
            'packs' => $packs
        ]);
    }

    public function help() {
        return Inertia::render('Setting/Help');
    }
}
