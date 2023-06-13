<?php

namespace App\Repositories\OneClickVid;

use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Traits\Crypt;
use App\Http\Traits\Url;
use App\Models\Integrable;
use App\Models\Investor;
use App\Models\User;
use App\Notifications\CreativeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RequestRepository
{
    use Crypt;
    use Url;
    public function store($request)
    {
        $product = $this->encrypt_decrypt('encrypt', $request->product, 'create Request');
        $platform = $this->encrypt_decrypt('encrypt', $request->platform, 'create Request');
        $type = $this->encrypt_decrypt('encrypt', $request->type, 'create Request');
        $duration = $this->encrypt_decrypt('encrypt', $request->duration, 'create Request');
        $music = $this->encrypt_decrypt('encrypt', $request->music === false ? 0 : 1, 'create Request');
        $voice = $this->encrypt_decrypt('encrypt', $request->voice === false ? 0 : 1, 'create Request');
        $observation = $this->encrypt_decrypt('encrypt', $request->observation, 'create Request');

        Http::withToken($this->token())->post($this->link().'/api/create/request/',[
            'product'=>$product,
            'platform'=>$platform,
            'type'=>$type,
            'duration'=>$duration,
            'music'=>$music,
            'voice'=>$voice,
            'observation'=>$observation
        ]);
    }

    public function Rate(Request $request,$id)
    {
        Http::asForm()->withToken($this->token())
            ->withHeaders([
                'cpl'=>$request->cpl,
                'cpc'=>$request->cpc,
                'observations'=>$request->observation,
                'rates'=>$request->rate
                ])
            ->put($this->link().'/api/rateCreative/'. $id );
    }

    public function update($request,$id)
    {
        $product = $this->encrypt_decrypt('encrypt', $request->product, 'update Request');
        $platform = $this->encrypt_decrypt('encrypt', $request->platform, 'update Request');
        $type = $this->encrypt_decrypt('encrypt', $request->type, 'update Request');
        $duration = $this->encrypt_decrypt('encrypt', $request->duration, 'update Request');
        $music = $this->encrypt_decrypt('encrypt', $request->music === false ? 0 : 1, 'update Request');
        $voice = $this->encrypt_decrypt('encrypt', $request->voice === false ? 0 : 1, 'update Request');
        $observation = $this->encrypt_decrypt('encrypt', $request->observation, 'update Request');

         Http::withToken($this->token())->withHeaders([
            'product'=>$product,
            'platform'=>$platform,
            'type'=>$type,
            'duration'=>$duration,
            'music'=>$music,
            'voice'=>$voice,
            'observation'=>$observation
        ])
        ->put($this->link().'/api/requests/'.$id);
        

    }

    public function destroy( $id)
    {
         Http::withToken($this->token())->delete($this->link().'/api/requests/'.$id);

        return back();
    }

    public function getCreativesNotification($id,$investor_id,$message,$route)
    {
        $investor=Investor::findorfail($investor_id);
        $investor->user->notify(new CreativeNotification($id,$message,$route));

        return response()->json([$id, $message, $route]);
    }
}