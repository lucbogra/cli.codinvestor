<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Requests\SecondStepRegisterRequest;
use App\Http\Requests\ThirdStepRegisterRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RegisterStepsController extends Controller
{

  private $update_user;
  public function __construct(UpdateUserProfileInformation $update_user)
  {
    $this->update_user = $update_user;
  }

  public function change_email(Request $request)
  {
    // dd( collect(json_decode($request->user()->registration_steps)->steps)->where('status', 'current')->first());
    $this->update_user->update(request()->user(), [ 'name' => request()->user()->name, 'email' => $request['email'] ]);
    return Redirect::route('verification.notice');
  }

  public function second_step(SecondStepRegisterRequest $request)
  {
    $request->validated();

    $user = request()->user();

    $user->investor()->update([
      // $request->only('company', 'address', 'country', 'city', 'zip')
      'company' => $request->company,
      'address' => $request->address,
      'country' => $request->country,
      'city' => $request->city,
      'zip' => $request->zip,
    ] );

    $user->registration_steps = json_encode(
      [
        'current' => 3,
        'finished' => false,
      ]
    );

    $user->save();

    return Redirect::route('user.register.steps');
  }

  public function third_step(ThirdStepRegisterRequest $request)
  {
    $request->validated();

    // dd($request->all());

    $user = request()->user();

    $user->investor()->update([
      'responses' => json_encode([
        [ 'question' => 'Do you have any experience with COD affiliate marketing ?', 'response' => $request->affiliate_experience ],
        [ 'question' => 'Can you talk about your experience and share their names with us ?', 'response' => $request->other_networks ],
        [ 'question' => 'In which country are you currently working ?', 'response' => $request->working_country ],
        [ 'question' => 'What are the advertising platforms you use ?', 'response' => $request->ads_platforms ],
        [ 'question' => 'How did you hear about us ?', 'response' => $request->survey ]
      ])
    ]);

    $user->registration_steps = json_encode(
      [
        'current' => 4,
        'finished' => false,
      ]
    );

    $user->save();

    return Redirect::route('user.register.steps');
  }

  public function fourth_step(Request $request)
  {

    $request->validate([
      'photo' => ['file', 'mimes:png,jpg', 'max:2048', 'required']
    ]);

    $user = request()->user();
    $photo = $request->file('photo')->store('documents', 's3');
    $user->investor()->update([
      'cin' => $photo
    ]);

    $user->registration_steps = json_encode(
      [
        'current' => 5,
        'finished' => false,
      ]
    );

    $user->save();

    return Redirect::route('user.register.steps');

  }
}
