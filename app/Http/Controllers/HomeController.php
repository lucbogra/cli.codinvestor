<?php

namespace App\Http\Controllers;

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
}
