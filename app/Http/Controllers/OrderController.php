<?php

namespace App\Http\Controllers;

use App\Imports\OrderImport;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function orders() {
        $uploadeds = Order::where('investor_id', auth()->id())->get();
        $duplicates = Order::where('duplicate', 1)->get();
        $rejecteds = Order::where('status', 'rejected')->get();
        return Inertia::render('Orders/Index', [
            'uploadeds' => $uploadeds,
            'duplicates' => $duplicates,
            'rejecteds' => $rejecteds
        ]);
    }

    public function import(Request $request) {
       $validateData =  Validator::make($request->all(), [
            'file' => 'required', 'mimes:xlsx,xlsm,xlsb,xltx,xls,csv'
        ]);
        if($validateData->fails()) {
            return 0;
        } else {
            (new OrderImport(auth()->id()))->import($request->file('file'));
            return redirect()->route('orders.index');
        }
    }
}
