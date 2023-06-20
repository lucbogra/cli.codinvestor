<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
      // dd(config('services.recaptcha.secret_key'));
      $response = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
        'secret' => config('services.recaptcha.secret_key'),
        'response' => $input['recaptcha_token'],
        'ip' => request()->ip(),
      ]);

      // dd([$response->json('success'), $response->json('score')]);

      $messages = [
        'required' => 'The :attribute field is required.',
        'max' => 'The :attribute must not exceed 255 caracters',
        'email' => 'The :attribute field must be a valid email address',
        'confirmed' => 'The :attribute must match with the password confirmation field',
        'numeric' => 'The :attribute must be a number',
        'unique' => 'The :attribute is already use'
      ];
      Validator::make($input, [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
        'phone' => ['required', 'numeric'],
        'password' => $this->passwordRules(),
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        'recaptcha_token' => ['required', new Recaptcha($input['recaptcha_token'])],
      ], $messages)->validate();

      $user = User::create([
        'name' => $input['first_name'].' '.$input['last_name'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
      ]);

      $investor = $user->investor()->create([
        'first_name' => $input['first_name'],
        'last_name' => $input['last_name'],
        'email' => $input['email'],
        'phone' => $input['phone'],
        // 'manager_id' => User::role('Account Manager')->where('active', 1)
      ]);

      $investor->project()->create([
        'name' => $user->name,
        'type' => 'COD',
      ]);

      $user->assignRole('Investor');

      return $user;
    }
}
