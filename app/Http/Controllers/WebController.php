<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use App\Models\Ticket;
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

    public function createTicket()
    {
        return Inertia::render('Setting/Ticket');
    }

    public function storeTicket(Request $request) {
        // return $request->all();
        $request->validate([
            'subject' => 'required',
            'content' => 'required'
        ]);
        $ticket = new Ticket();
        $ticket->investor_id = auth()->id();
        $ticket->subject = $request->subject;
        $ticket->content = $request->content;
        $ticket->save();
        return back();
    }
}
