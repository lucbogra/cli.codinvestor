<?php

namespace App\Http\Requests;

use App\Models\Member;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      return request()->user()->hasRole('Investor');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
      return [
        'name' => ['required_if:type,infos', 'max:50'],
        'email' => ['required_if:type,infos', 'email', 'max:255', 'unique:users,email,'.$this->input('user_id')],
        'password'   => 'required_if:type,password|min:8|max:30',
        'confirm_password' => 'required_if:type,password|required_with:password|same:password|min:8|max:30',
      ];
    }
}
