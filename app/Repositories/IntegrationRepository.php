<?php

namespace App\Repositories;

use App\Http\Resources\FundingResource;
use App\Models\Funding;
use App\Models\Integration;
use Illuminate\Support\Facades\Storage;

class IntegrationRepository
{
    public function store($request)
    {
        
        $imageName = time().$request->file('logo')->getClientOriginalName();

        $path = 'storage/Integration/' . $imageName;
        $request->file('logo')->storeAs('Integration', $imageName, 'public');

        Integration::create([
            'name'=>$request->name,
            'external_link'=>$request->external_link,
            'description'=>$request->description,
            'logo'=> $path
        ]);
    }
}
