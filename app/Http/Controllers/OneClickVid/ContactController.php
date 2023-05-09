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
class ContactController extends Controller
{
    use Url;
    protected $contactrepository;
    
    public function __construct(ContactRepository $contactrepository)
    {
        $this->contactrepository=$contactrepository;
    }
    public function messages(Request $request)
    {
        // dd($request->all());
        return $this->contactrepository->create_message($request);
        
    }

    public function getmessages()
    {
        $response=Http::withToken($this->token())->withHeaders(['Accept'=>'application/json'])->get($this->link().'/api/userMessages');

        return $response->json();
    }

    public function sendMessage(Request $request,$id)
    {
        return $this->contactrepository->sendMessage($request,$id);
        
    }

    public function createContactNotification($id,$message,$route)
    {   
        $this->contactrepository->createContactNotification($id,$message,$route);

    }


}
