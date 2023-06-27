<?php

namespace App\Http\Controllers\OneClickVid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\Url;
use App\Models\User;
use App\Notifications\ContactNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Repositories\OneClickVid\ContactRepository;
use App\Repositories\OneClickVid\PackRepository;

class PackController extends Controller
{
    use Url;
    protected $packreposirtory;
    
    public function __construct(PackRepository $packreposirtory)
    {
        $this->packreposirtory=$packreposirtory;
    }

    public function getpacks()
    {
        return $this->packreposirtory->getpacks();
    }

    public function subscribe(Request $request)
    {
        $this->packreposirtory->subscribe($request);
        
        return back()->with('success','Subscribe Successfully');
    }
}
