<?php

namespace App\Http\Traits;

use App\Models\Integrable;
use Illuminate\Support\Facades\Auth;

trait Url{
    function link()
    {
        if(app()->environment('local'))
        {
            return 'http://admin.oneclickvid.test';
        }
        else{
            return 'https://adminapp.oneclickvid.com';
        }
    }

    function token()
    {
        $integrable=Integrable::where('integrable_id',Auth::user()->investor->id)
        ->where('integrable_type','App\Models\Investor')->orderBy('created_at','desc')->first('token');

        return $integrable->token;
    }
}