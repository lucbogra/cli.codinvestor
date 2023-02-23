<?php

namespace App\Http\Controllers;

use App\Actions\ReadMessage;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends Controller
{
  public $read_message;
  public function __construct(ReadMessage $read_message)
  {
    $this->read_message = $read_message;
  }
  public function index()
  {
    return Inertia::render('Messages/Index', [
      'messages' => MessageResource::collection(request()->user()->messages()->with('users')->get())
    ]);
  }

  public function all()
  {
    return response()->json( MessageResource::collection(request()->user()->messages()->with('users')->get()) );
  }

  public function show(Message $message)
  {
    $this->read_message->action($message);
    return Inertia::render('Messages/Show', [
      'message' => new MessageResource($message)
    ]);
  }
}
