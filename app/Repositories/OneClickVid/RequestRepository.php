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

        // $integrable=Integrable::where('integrable_id',Auth::user()->investor->id)
        // ->where('integrable_type','App\Models\Investor')->first('token');

        $product = $this->encrypt_decrypt('encrypt', $request->product, 'create Request');
        $platform = $this->encrypt_decrypt('encrypt', $request->platform, 'create Request');
        $type = $this->encrypt_decrypt('encrypt', $request->type, 'create Request');
        $duration = $this->encrypt_decrypt('encrypt', $request->duration, 'create Request');
        $music = $this->encrypt_decrypt('encrypt', $request->music === false ? 0 : 1, 'create Request');
        $voice = $this->encrypt_decrypt('encrypt', $request->voice === false ? 0 : 1, 'create Request');
        $observation = $this->encrypt_decrypt('encrypt', $request->observation, 'create Request');

        // dd([$this->token(),'http://127.0.0.1:8002/api/create/request/'. $product . '/' . $platform . '/' . $type . '/' . $duration . '/' . $music . '/' . $voice . '/' . $observation]);
        Http::withToken($this->token())->post($this->link().'/api/create/request/'. $product . '/' . $platform . '/' . $type . '/' . $duration . '/' . $music . '/' . $voice . '/' . $observation);
        // Http::withToken($integrable->token)->post('http://127.0.0.1:8002/api/create/request/'. $product . '/' . $platform . '/' . $type . '/' . $duration . '/' . $music . '/' . $voice . '/' . $observation);
    }

    public function Rate(Request $request,$id)
    {
        // $integrable=Integrable::where('integrable_id',Auth::user()->investor->id)
        // ->where('integrable_type','App\Models\Investor')->first('token');

        Http::withToken($this->token())
            ->withHeaders([
                'cpl'=>$request->cpl,
                'cpc'=>$request->cpc
                ])
            ->put($this->link().'/api/rateCreative/'. $id .'/' . $request->rate . '/' . $request->observation);
            // ->put('http://127.0.0.1:8002/api/rateCreative/'. $id .'/' . $request->rate . '/' . $request->observation);
    }

    public function update($request,$id)
    {
        // $integrable=Integrable::where('integrable_id',Auth::user()->investor->id)
        // ->where('integrable_type','App\Models\Investor')->first('token');
        //dd($integrable);
        // $token_user = $integrable->token;
        $product = $this->encrypt_decrypt('encrypt', $request->product, 'update Request');
        $platform = $this->encrypt_decrypt('encrypt', $request->platform, 'update Request');
        $type = $this->encrypt_decrypt('encrypt', $request->type, 'update Request');
        $duration = $this->encrypt_decrypt('encrypt', $request->duration, 'update Request');
        $music = $this->encrypt_decrypt('encrypt', $request->music === false ? 0 : 1, 'update Request');
        $voice = $this->encrypt_decrypt('encrypt', $request->voice === false ? 0 : 1, 'update Request');
        $observation = $this->encrypt_decrypt('encrypt', $request->observation, 'update Request');

        // dd([$token_user,$product,$platform,$type,$duration,$music,$voice,$observation]);
         Http::withToken($this->token())->withHeaders([
            'product'=>$product,
            'platform'=>$platform,
            'type'=>$type,
            'duration'=>$duration,
            'music'=>$music,
            'voice'=>$voice,
            'observation'=>$observation
        ])
        // ->put('http://127.0.0.1:8002/api/requests/'.$id);
        ->put($this->link().'/api/requests/'.$id);
        

    }

    public function destroy( $id)
    {
        // $integrable=Integrable::where('integrable_id',Auth::user()->investor->id)
        // ->where('integrable_type','App\Models\Investor')->first('token');
        //dd($integrable);
         Http::withToken($this->token())->delete($this->link().'/api/requests/'.$id);
        // Http::withToken($integrable->token)->delete('http://127.0.0.1:8002/api/requests/'.$id);

        return back();
    }

    public function getCreativesNotification($id,$investor_id,$message,$route)
    {
        $investor=Investor::findorfail($investor_id);
        $investor->user->notify(new CreativeNotification($id,$message,$route));

        return response()->json([$id, $message, $route]);
    }
}