<?php

namespace App\Repositories\OneClickVid;

use App\Http\Traits\Url;
use App\Models\Integrable;
use App\Models\IntegrationPayment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use function GuzzleHttp\Promise\all;

class PackRepository{

    use Url;
    
    public function getpacks()
    {
        return Http::withToken($this->token())->get($this->link().'/api/packs');
    }

    public function subscribe($request)
    {
        $integrable=Integrable::where('integrable_id',Auth::user()->investor->id)
        ->where('integrable_type','App\Models\Investor')
        ->wherehas('integration',function  (Builder $builder){
            $builder->where('name','One Click Vid');
        })->first();

        $duration_type= $request->pack['duration']<=1 ? substr_replace($request->pack['duration_type'],'',-1) :  $request->pack['duration_type'] ;
        
        IntegrationPayment::create([
            'integration_id'=>$integrable->integration_id,
            'integrable_id'=>$request->user()->investor->id,
            'integrable_type'=>$request->user()->investor->getMorphClass(),
            'amount'=>$request->pack['cost'],
            'payment_info'=>$request->pack['name'].' -  '.$request->pack['duration'].' '.$duration_type .' - '.date('Y-m-d'),
            'status'=>$request->pack['cost']==0 ? 'paid' : 'pending'
        ]);
        
        Http::withToken($this->token())->post($this->link().'/api/subsribePack',[
            'pack_id'=>$request->pack['id']
        ]);
    }
}