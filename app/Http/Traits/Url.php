<?php

namespace App\Http\Traits;

use App\Models\Integrable;
use Illuminate\Support\Facades\Auth;

trait Url{
    function link()
    {
        // $output = 'http://127.0.0.1:8002';

        $output = 'https://adminapp.oneclickvid.com';

        return $output;
    }

    function token()
    {
        $integrable=Integrable::where('integrable_id',Auth::user()->investor->id)
        ->where('integrable_type','App\Models\Investor')->first('token');

        return $integrable->token;
    }
}