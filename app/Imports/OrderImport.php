<?php

namespace App\Imports;

use App\Models\Investor;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
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

        return new Order([
            'customer_name'              => $row['customer name'],
            'phone'                      => $row['customer phone'],
            'customer_city'              => $row['customer city'],
            'product_name'               => $row['product sku'],    //Helper::_getRealSku($row['product']),
            'country'                    => $row['country'],
            'website'                    => $row['website'],
            'price'                      => $row['price'],
            'investor_id'                => $this->investor_id,
            'status'                     => in_array($row['product sku'], $this->products()) ? 'pending' : 'rejected'
            // 'sup_id'                     => Auth::user()->supof ? Auth::user()->id : null,
            // 'product_link'               => WebsiteProduct::where('website_sku', Helper::_getRealSku($row['product']))->first() ? WebsiteProduct::where('website_sku', Helper::_getRealSku($row['product']))->first()->link : '#',
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

    public function products(){
      return Investor::find($this->investor_id)->products()->pluck('sku')->toArray();
    }
}
