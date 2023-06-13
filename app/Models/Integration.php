<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Integration extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
        'logo',
        'external_link'
    ];

    public function getLogoAttribute(){
      return Storage::disk('s3')->temporaryUrl($this->attributes['logo'], now()->addMinutes(100));
    }

    public function investors()
    {
      return $this->morphedByMany(Investor::class, 'integrable');
    }

    public function Integration_investors()
    {
      return $this->morphMany(Investor::class, 'integrable');
    }


    public function filter_investor($investor_id,$investormorphclass)
    {
      return $this->whereDoesntHaveMorph('investors', $investormorphclass, function ($query) use ($investor_id) {
      $query->where('integrable_id','!=', $investor_id);
      })->get();
    }
}
