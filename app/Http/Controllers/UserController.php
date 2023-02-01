<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvestorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends Controller
{
  public function company()
  {
    return Inertia::render('Users/Company', [
      'investor' => new InvestorResource(Auth::user()->investor)
    ]);
  }

  public function update_company(Request $request)
  {
    $request->validate([
      'company' => ['max:255'],
      'phone' => ['max:20'],
      'address' => ['max:255'],
      'city' => ['max:50'],
      'country' => ['max:50'],
      'website' => ['max:255']
    ]);

   request()->user()->investor()->update($request->all());

   return Redirect::back()->with('success', 'informations updated.');
  }
}
