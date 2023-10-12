<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThirdStepRegisterRequest extends FormRequest
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
        'affiliate_experience' => ['required', 'in:yes,no'],
        'working_country' => ['required', 'max:255'],
        'ads_platforms' => ['required', 'array', 'max:255'],
        'other_networks' => [ 'max:255'],
        'survey' => ['max:255']
      ];
    }
}
