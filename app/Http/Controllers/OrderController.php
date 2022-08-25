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
        $uploadeds = Order::where('investor_id', auth()->id())->whereDate('created_at', date('Y-m-d'))->where('duplicate', 0)->whereNot('status', 'rejected')->get();
        $duplicates = Order::where('duplicate', 1)->whereDate('created_at', date('Y-m-d'))->get();
        $rejecteds = Order::where('status', 'rejected')->whereDate('created_at', date('Y-m-d'))->get();
        $wrong_number = Order::where('status', 'wrong number')->whereDate('created_at', date('Y-m-d'))->get();
        return Inertia::render('Orders/Index', [
            'uploadeds' => $uploadeds,
            'duplicates' => $duplicates,
            'rejecteds' => $rejecteds,
            'wrong_number' => $wrong_number
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
