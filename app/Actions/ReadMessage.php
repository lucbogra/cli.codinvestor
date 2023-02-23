<?php

namespace App\Actions;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReadMessage
{
  public function action(Message $message)
  {
    if($message->users()->where('users.id', Auth::id())->first()->pivot->read_at == null){
      $message->users()->updateExistingPivot(Auth::id(), [
        'read_at' => Carbon::now()->toDateTimeString()
      ]);
    }
  }
}
