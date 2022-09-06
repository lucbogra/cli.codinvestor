<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PaymentMethodController extends Controller
{
  public function index(){
    $payment_method = PaymentMethod::firstOrCreate(['investor_id' =>  auth()->user()->investor->id],
      ['datas' => json_encode(['bank_account' => '', 'maroccan_bank_account' => '', 'payoneer' => '', 'paypal' => '', 'transferwise' => '', 'default' => ''])]
    );

    return Inertia::render('PaymentMethods/Index', [
      'datas' => $payment_method
    ]);
  }

  public function update(Request $request){

    $payment_method = PaymentMethod::firstOrCreate(['investor_id' =>  auth()->user()->investor->id],
      ['datas' => json_encode(['bank_account' => '', 'maroccan_bank_account' => '', 'payoneer' => '', 'paypal' => '', 'transferwise' => '', 'default' => ''])]
    );

    if($request->type == 'Bank Account'){
      if ($request->default == true){
         $request->validate([
        'account_type' => [Rule::in(['personnal', 'business'])],
        'email' => ['required', 'email', 'max:255'],
        'bank_name' => ['required', 'max:255'],
        'account_currency' => ['required', 'max:50'],
        'account_owner_name' => ['required', 'max:150'],
        'iban' => ['required', 'max:50'],
        'rib' => ['required', 'max:50'],
        'swift_code' => ['required', 'max:20'],
        'country' => ['required', 'max:50'],
        'address' => ['required', 'max:255'],
        'city' => ['required', 'max:100'],
        'zip_code' => ['required', 'max:10']
      ]);
      }

      $payment_method->update([
        'datas->bank_account' => FacadesRequest::all('account_type', 'email', 'bank_name', 'account_currency', 'account_owner_name', 'iban', 'rib', 'swift_code', 'country', 'address', 'city', 'zip_code'),
      ]);
      if($request->default == true){
        $payment_method->update([
          'datas->default' => FacadesRequest::all('type', 'account_type', 'email', 'bank_name', 'account_currency', 'account_owner_name', 'iban', 'rib', 'swift_code', 'country', 'address', 'city', 'zip_code'),
        ]);
      }
    }elseif($request->type == 'Maroccan Bank Account'){
      if ($request->default == true){
        $request->validate([
          'account_type' => [Rule::in(['personnal', 'business'])],
          'email' => ['required', 'email', 'max:255'],
          'bank_name' => ['required', 'max:255'],
          'account_owner_name' => ['required', 'max:150'],
          'iban' => ['required', 'max:50'],
          'rib' => ['required', 'max:50'],
          'swift_code' => ['required', 'max:20'],
          'address' => ['required', 'max:255'],
          'city' => ['required', 'max:100'],
          'zip_code' => ['required', 'max:10']
        ]);
      }
      $payment_method->update([
        'datas->maroccan_bank_account' => FacadesRequest::all('account_type', 'email', 'bank_name', 'account_owner_name', 'iban', 'rib', 'swift_code', 'address', 'city', 'zip_code'),
      ]);
      if($request->default == true){
        $payment_method->update([
          'datas->default' => FacadesRequest::all('type', 'account_type', 'email', 'bank_name', 'account_owner_name', 'iban', 'rib', 'swift_code', 'address', 'city', 'zip_code'),
        ]);
      }

    }elseif($request->type == 'Payoneer'){
      if ($request->default == true){
        $request->validate([
          'account_type' => ['required', 'max:100'],
          'email' => ['required', 'email', 'max:255'],
          'account_holder' => ['required', 'max:255'],
          'routing_number' => ['required', 'max:150'],
          'address' => ['required', 'max:255'],
          'country' => ['required', 'max:100'],
          'account_currency' => ['required', 'max:50'],
        ]);
      }
      $payment_method->update([
        'datas->payoneer' => FacadesRequest::all('account_type', 'email', 'account_holder', 'routing_number', 'address', 'country', 'account_currency'),
      ]);
      if($request->default == true){
        $payment_method->update([
          'datas->default' => FacadesRequest::all('type', 'account_type', 'email', 'account_holder', 'routing_number', 'address', 'country', 'account_currency'),
        ]);
      }

    }elseif($request->type == 'Paypal'){
      if ($request->default == true){
        $request->validate([
          'email' => ['required', 'email', 'max:255'],
        ]);
      }
      $payment_method->update([
        'datas->paypal' => FacadesRequest::all( 'email'),
      ]);
      if($request->default == true){
        $payment_method->update([
          'datas->default' => FacadesRequest::all('type', 'email'),
        ]);
      }

    }elseif($request->type == 'TransferWise'){
      if ($request->default == true){
        $request->validate([
          'account_type' => ['required', 'max:100'],
          'email' => ['required', 'email', 'max:255'],
          'account_number' => ['required', 'max:255'],
          'account_holder' => ['required', 'max:255'],
          'routing_number' => ['required', 'max:150'],
          'swift_code' => ['required', 'max:20'],
          'address' => ['required', 'max:255'],
          'country' => ['required', 'max:100'],
          'account_currency' => ['required', 'max:50'],
        ]);
      }
      $payment_method->update([
        'datas->transferwise' => FacadesRequest::all('account_type', 'email', 'account_number', 'account_holder', 'routing_number', 'swift_code', 'address', 'country', 'account_currency'),
      ]);
      if($request->default == true){
        $payment_method->update([
          'datas->default' => FacadesRequest::all('type', 'account_type', 'account_number', 'email', 'account_holder', 'routing_number', 'swift_code', 'address', 'country', 'account_currency'),
        ]);
      }

    }

    return Back()->with('success', 'Payment settings successfully updated');
  }
}
