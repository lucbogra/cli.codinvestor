<?php

namespace App\Repositories\OneClickVid;

use App\Notifications\ContactNotification;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\Url;
use App\Models\Investor;
use App\Models\User;
use AWS\CRT\HTTP\Request;
use Illuminate\Support\Facades\Auth;

class ContactRepository
{
    use Url;

    public function create_message($request)
    {
        $response=Http::asForm()->withToken($this->token())->withHeaders(['Accept'=>'application/json'])->post($this->link().'/api/messages', [
            'messages' => serialize($request->message_data),
            'type'=>'sent'
        ]);

         $message=json_decode($response->getBody()->getContents());

        //  dd($message->messages);
        if($message->message==='success')
        {
            return back()->with('success','Successfully');
        }
        else
        {
            return back()->with('error','error');
        }
        
    }

    public function sendMessage($request,$id)
    {
        // dd($request->all());
        $request->user()->investor->unreadNotifications->where('type', 'App\Notifications\ContactNotification')->markAsRead();

        $response=Http::asForm()->withToken($this->token())->withHeaders(['Accept'=>'application/json'])->put($this->link().'/api/SendMessage/'.$id, [
            'messages' => serialize($request->message_data),
            'type'=>'sent'
        ]);

        // $message=json_decode($response->getBody()->getContents());

        return back();
        //  dd($message->message);
        // if($message->message=='success')
        // {
        //     return back();
        // }
        // else
        // {
        //     return back()->with('error','error ');
        // }
    }

    public function createContactNotification($id,$message,$route)
    {
        // dd([$id,$message,$route]);
        $user=Investor::findorfail((int)$id);
        
        
        $user->notify(new ContactNotification($message,$route));
    }
}