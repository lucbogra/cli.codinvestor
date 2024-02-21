<?php

namespace App\Http\Requests;

use App\Models\Investor;
use App\Models\Location;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderImportRequest extends FormRequest
{
  public function __construct(public $investor_id)
  {

  }
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
          '*.customer name'      =>  ['required', 'max:255'],
          '*.customer city'      =>  ['required', 'max:255'],
          '*.customer phone'     =>  ['required', 'max:255'],
          '*.product sku'   =>  ['required', 'max:255', Rule::in( Investor::find($this->investor_id)->accessProducts()->select('products.alias')->get()->pluck('alias')->map(function($item){return json_decode($item);})->flatten(2) )],
          '*.website'   =>  ['required', 'max:255'],
          '*.country'   =>  ['nullable', 'max:255', Rule::In(Location::select('country')->get()->pluck('country')) ],
          '*.price' => ['required']
        ];
    }

    public function withValidator($validator)
{
    $validator->after(function ($validator) {
        if ($this->somethingElseIsInvalid()) {
            $validator->errors()->add('field', 'Something is wrong with this field!');
        }
    });
}
}
