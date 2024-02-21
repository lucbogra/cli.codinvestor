<?php

namespace App\Imports;

use App\Http\Requests\OrderImportRequest;
use App\Jobs\ImportOrdersjob;
use App\Models\Investor;
use App\Models\Location;
use App\Models\Order;
use App\Models\Product;
use App\Models\Utils\Helper;
use App\Models\WebsiteProduct;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class OrderImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
// , WithBatchInserts, WithChunkReading
{
  use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
  protected $investor_id;
  public function __construct(int $investor_id)
  {
    $this->investor_id = $investor_id;
  }

  public function collection($rows)
  {

    $validator = Validator::make($rows->toArray(), [
      '*.customer name'      =>  ['required', 'max:255'],
      '*.customer city'      =>  ['required', 'max:255'],
      '*.customer phone'     =>  ['required', 'max:255'],
      '*.product sku'   =>  ['required', 'max:255', Rule::in( Investor::find($this->investor_id)->accessProducts()->select('products.alias')->get()->pluck('alias')->map(function($item){return json_decode($item);})->flatten(2) )],
      '*.website'   =>  ['required', 'max:255'],
      '*.country'   =>  ['nullable', 'max:255', Rule::In(Location::select('country')->get()->pluck('country')) ],
      '*.price' => ['required', 'numeric']
    ]);

    //  $validator->sometimes('*.price', 'required', function($data, $item) use($validator) {

    //   $product = $this->products($item['product sku']);

    //   $value = $item['price'];

    //   $prices = $product ? collect( collect(json_decode( $product->pricings )->pricings)->where('country', $item['country'] )->first()?->prices)->pluck('price')->toArray() : [];

    //   return in_array($value, $prices);
    // });

    $validator->validate();

    // because I can't validate prices with validator (I have to retry it next time)
    foreach($rows->toArray() as $row) {
      $product =  $this->products($row['product sku']);
      $prices = $product ? collect( collect(json_decode( $product->pricings )->pricings)->where('country', $row['country'] )->first()?->prices)->pluck('price')->toArray() : [];

      Validator::make($row, [
        'price' => ['required', Rule::In($prices)]
      ])->validate();
    }

      foreach($rows->toArray() as $row)
      {
        $product = $this->products($row['product sku']);

        // dd(collect( collect(json_decode( $product->pricings )->pricings)
        // ?->where('country', $row['country'])
        // ->first()->prices)->where('price', $row['price'])
        // ->first()?->commission);

         Order::create([
          'customer_name'              => $row['customer name'],
          'phone'                      => $row['customer phone'],
          'customer_city'              => $row['customer city'],
          'product_name'               => $row['product sku'],    //Helper::_getRealSku($row['product']),
          'country'                    => $row['country'],
          'website'                    => $row['website'],
          'price'                      => $row['price'],
          'orderable_id'               => $this->investor_id,
          'orderable_type'             => 'App\Models\Investor',
          'status'                     => $this->setStatus($product, $row['price']),
          'product_link'               => isset($product) ? ( isset($product->pivot->link ) != null ? $product->pivot->link : $product->website_link ) : null,
          'product_id'                 => isset($product) ? $product->id : null,
          'commission'                 => isset($product) ? collect( collect(json_decode( $product->pricings )->pricings)
                                                                                          ?->where('country', $row['country'])
                                                                                          ->first()?->prices)->where('price', $row['price'])
                                                                                          ->first()?->commission : 0,
          'source'                     => 'importation',
        ]);
      }

  }

    public function rules(): array
    {
      return [
        'customer name'      =>  ['required', 'max:255'],
        'customer city'      =>  ['required', 'max:255'],
        'customer phone'     =>  ['required', 'max:255'],
        'product sku'   =>  ['required', 'max:255', Rule::in( Investor::find($this->investor_id)->accessProducts()->select('products.alias')->get()->pluck('alias')->map(function($item){return json_decode($item);})->flatten(2) )],
        'website'   =>  ['required', 'max:255'],
        'country'   =>  ['nullable', 'max:255', Rule::In(Location::select('country')->get()->pluck('country')) ],
        'price'     => ['required', 'numeric']
      ];
    }

    public function withValidator($validator)
    {
      // $validator->sometimes('price', 'required', function() use($validator) {

      //   $product = $this->products(collect($validator->getData())->pluck('product sku')->first());

      //   $value = collect($validator->getData())->pluck('price')->first();

      //   $prices = $product ? collect( collect(json_decode( $product->pricings )->pricings)->where('country', collect($validator->getData())->pluck('country')->first() )->first()->prices)->pluck('price')->toArray() : [];

      //   if( ! in_array($value, $prices)){
      //     $validator->errors()->add('price', 'Pricing is not allowed.');
      //   }
      // });
    }

    public function batchSize(): int
    {
      return 300;
    }

    public function chunkSize(): int
    {
      return 300;
    }

    public function products($sku){
      // if(Investor::find($this->investor_id)->user->email == 'oneads@codinvestor.com'){
      //   return Product::whereJsonContains('alias', $sku)->first();
      // }
      return Investor::find($this->investor_id)->accessProducts()->whereJsonContains('alias', $sku)->first();
    }

    // public function pricings($product, $price)
    // {
    //   $pricings = $product->pivot->commission_type == 'fix'
    //   ? collect(json_decode($product->pricings)->pricings)->where('price', $product->pivot->affiliate_price)->where('commission_type', 'fix')->flatten()->all()
    //   : collect(json_decode($product->pricings)->pricings)->where('commission_type', $product->pivot->commission_type)->where('price', $product->pivot->affiliate_price)->pluck('occurences')->flatten()->all();
    //   return $pricings ? json_encode($pricings) : null ;
    // }

    public function setStatus($product, $price)
    {
      if(Investor::find($this->investor_id)->user->email == 'oneads@codinvestor.com')
      {
        return 'pending';
      }
      elseif(isset($product)){
        if($product->pivot->affiliate_price != (double)$price) {
          return 'rejected';
        }
        else return 'pending';
      }else return 'rejected';
    }
}
