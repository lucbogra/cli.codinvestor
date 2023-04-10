<?php

namespace App\Repositories;

use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Traits\Crypt;
use App\Models\Investor;
use App\Models\User;
use App\Notifications\CreativeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RequestRepository
{
    use Crypt;
    public function store($request)
    {

        // dd($request->all());
        $token = PersonalAccessToken::where('tokenable_type', Auth()->user()->investor->getMorphClass())
            ->where('tokenable_id', Auth()->user()->investor->id)
            ->orderBy('created_at', 'desc')->first();
        // dd(Auth()->user()->investor->id);
        $token_user = $token->name;
        $product = $this->encrypt_decrypt('encrypt', $request->product, 'create Request');
        $platform = $this->encrypt_decrypt('encrypt', $request->platform, 'create Request');
        $type = $this->encrypt_decrypt('encrypt', $request->type, 'create Request');
        $duration = $this->encrypt_decrypt('encrypt', $request->duration, 'create Request');
        $music = $this->encrypt_decrypt('encrypt', $request->music === false ? 0 : 1, 'create Request');
        $voice = $this->encrypt_decrypt('encrypt', $request->voice === false ? 0 : 1, 'create Request');
        $observation = $this->encrypt_decrypt('encrypt', $request->observation, 'create Request');

        // dd('http://127.0.0.1:8002/api/create/request/' . $current_token . '/' . $product . '/' . $platform . '/' . $type . '/' . $duration . '/' . $music . '/' . $voice . '/' . $observation);
        Http::withToken($token_user)->post('http://127.0.0.1:8002/api/create/request/'. $product . '/' . $platform . '/' . $type . '/' . $duration . '/' . $music . '/' . $voice . '/' . $observation);
    }

    public function Rate(Request $request,$id)
    {
        $token = PersonalAccessToken::where('tokenable_type', Auth()->user()->investor->getMorphClass())
            ->where('tokenable_id', Auth()->user()->investor->id)
            ->orderBy('created_at', 'desc')->first();

        Http::withToken($token->name)
            ->withHeaders([
                'cpl'=>$request->cpl,
                'cpc'=>$request->cpc
                ])
            ->put('http://127.0.0.1:8002/api/rateCreative/'. $id .'/' . $request->rate . '/' . $request->observation);
    }

    public function update($request,$id)
    {
        $token = PersonalAccessToken::where('tokenable_type', Auth()->user()->investor->getMorphClass())
            ->where('tokenable_id', Auth()->user()->investor->id)
            ->orderBy('created_at', 'desc')->first();
        $token_user = $token->name;
        $product = $this->encrypt_decrypt('encrypt', $request->product, 'update Request');
        $platform = $this->encrypt_decrypt('encrypt', $request->platform, 'update Request');
        $type = $this->encrypt_decrypt('encrypt', $request->type, 'update Request');
        $duration = $this->encrypt_decrypt('encrypt', $request->duration, 'update Request');
        $music = $this->encrypt_decrypt('encrypt', $request->music === false ? 0 : 1, 'update Request');
        $voice = $this->encrypt_decrypt('encrypt', $request->voice === false ? 0 : 1, 'update Request');
        $observation = $this->encrypt_decrypt('encrypt', $request->observation, 'update Request');

         Http::withToken($token_user)->withHeaders([
            'product'=>$product,
            'platform'=>$platform,
            'type'=>$type,
            'duration'=>$duration,
            'music'=>$music,
            'voice'=>$voice,
            'observation'=>$observation
        ])->put('http://127.0.0.1:8002/api/requests/'.$id);

    }

    public function destroy( $id)
    {
        $token = PersonalAccessToken::where('tokenable_type', Auth()->user()->investor->getMorphClass())
            ->where('tokenable_id', Auth()->user()->investor->id)
            ->orderBy('created_at', 'desc')->first();
        $token_user = $token->name;

         Http::withToken($token_user)->delete('http://127.0.0.1:8002/api/requests/'.$id);

        return back();
    }

    public function getCreativesNotification($id,$investor_id,$message,$route)
    {
        $investor=Investor::findorfail($investor_id);
        $investor->user->notify(new CreativeNotification($id,$message,$route));

        return response()->json([$id, $message, $route]);
    }
}