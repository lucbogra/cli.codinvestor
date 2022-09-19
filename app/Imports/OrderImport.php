<?php

namespace App\Imports;

use App\Jobs\ImportOrdersjob;
use App\Models\Investor;
use App\Models\Order;
use App\Models\Product;
use App\Models\Utils\Helper;
use App\Models\WebsiteProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class OrderImport implements ToModel, WithHeadingRow, WithValidation
// , WithBatchInserts, WithChunkReading
{
  use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct(int $investor_id)
    {
      $this->investor_id = $investor_id;
    }

    public function model(array $row)
    {
        // ImportOrdersjob::dispatch($row);
        $product = $this->products($row['product sku']);

        return new Order([
            'customer_name'              => $row['customer name'],
            'phone'                      => $row['customer phone'],
            'customer_city'              => $row['customer city'],
            'product_name'               => $row['product sku'],    //Helper::_getRealSku($row['product']),
            'country'                    => $row['country'],
            'website'                    => $row['website'],
            'price'                      => $row['price'],
            'investor_id'                => $this->investor_id,
            'status'                     => Investor::find($this->investor_id)->user->email == 'oneads@codinvestor.com' ? 'pending' : (isset($product) ? 'pending' : 'rejected'),
            'product_link'               => isset($product) ? ( isset($product->pivot->link ) != null ? $product->pivot->link : $product->website_link ) : null,
            'product_id'                 => isset($product) ? $product->id : null,
            'commission'                 => isset($product) ? $product->commission : 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'customer name'      =>  ['required', 'max:255'],
            'customer city'      =>  ['required', 'max:255'],
            'customer phone'     =>  ['required', 'max:255'],
            'product sku'   =>  ['required', 'max:255'],
            'website'   =>  ['required', 'max:255'],
            'country'   =>  ['nullable', 'max:255'],
            'price'     =>  ['nullable', 'max:255'],
        ];
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
      if(Investor::find($this->investor_id)->user->email == 'oneads@codinvestor.com'){
        return Product::whereJsonContains('alias', $sku)->first();
      }
      return Investor::find($this->investor_id)->accessProducts()->whereJsonContains('alias', $sku)->first();
    }
}
