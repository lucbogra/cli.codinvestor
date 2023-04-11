<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SecondStepRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
      return [
        'company' => ['required', 'max:255'],
        'address' => ['required', 'max:255'],
        'country' => ['required', 'max:255'],
        'city' => ['required', 'max:255']
      ];
    }

    public function messages()
    {
      return[
        'required' => 'The :attribute field is required',
        'max' => 'The :attribute must not exceed 255 caracters',
      ];
    }
}
