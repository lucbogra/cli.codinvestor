<?php

namespace App\Http\Controllers;

use App\Models\Tuto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function profile() {
      return Inertia::render('Profile/Show');
    }

    public function all_notifications()
    {
      return Inertia::render('Setting/Notifications');
    }

    public function close_notification($id)
    {
      request()->user()->unreadNotifications->where('id', $id)->markAsRead();
      return back();
    }

    public function close_all_notifications()
    {
      request()->user()->unreadNotifications->markAsRead();
      return back();
    }

    public function help()
    {
      return Inertia::render('Setting/Help',[
        'tutos' => Tuto::orderBy('position', 'ASC')->get()
      ]);
    }

    public function tutos()
    {
      // no route
      return response()->json(
        Tuto::orderBy('position', 'ASC')->get()
      );
    }

    public function seller()
    {
      return Inertia::render('Setting/Seller');
    }

    public function seller_get_started()
    {
      request()->user()->investor->update([
        'seller_status' => 'request',
        'seller_request_at' => now()
      ]);

      return back()->with('success', 'request sent successfully');
    }
}
