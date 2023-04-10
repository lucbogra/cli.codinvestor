<?php

namespace App\Http\Controllers;

use App\Http\Requests\IntegrationRequest;
use App\Http\Resources\IntegrationResource;
use App\Models\Integrable;
use App\Models\Integration;
use App\Models\Investor;
use App\Models\Notification;
use App\Models\Product;
use App\Repositories\IntegrationRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Laravel\Sanctum\PersonalAccessToken;

class IntegrationController extends Controller
{
    public $integrationRepository;

    public function __construct(IntegrationRepository $integrationRepository)
    {
        $this->integrationRepository = $integrationRepository;
    }

    public function index()
    {
        $integrations_user=[];
        $integrations=[];
        if (Auth()->user()->role == 'Investor') {
            $integrations_user= Auth()->user()->investor->integrations()->get();
            $integrable=Integrable::where('integrable_id', Auth()->user()->investor->id)
                        ->where('integrable_type', Auth()->user()->investor->getMorphClass())
                        ->get("integration_id")->toarray();
             $integrations=Integration::whereNotIn('id', $integrable)->get();

            return Inertia::render('Integrations/Index', [
                'Integration_user' => IntegrationResource::collection($integrations_user),
                'Integrations' => $integrations,
            ]);
        }

        
    }

    public function oneclickVid()
    {
        $integrable=Integrable::where('integrable_id',Auth::user()->investor->id)
        ->where('integrable_type','App\Models\Investor')->first();
        if($integrable)
        {
            return Inertia::render('Integrations/OneClickVid/Index',[
                'products'=>Product::all()
            ]);
        }
        else
        {
           return  $this->index();
        }
       
    }

    public function request_show($id)
    {
        Notification::wherejsoncontains('data->id', $id)->update(['read_at'=> now()]);
        $token=PersonalAccessToken::where('tokenable_id', Auth::user()->investor->id)->orderby('created_at', 'desc')->first('name');
        $request=Http::withToken($token->name)->get('http://127.0.0.1:8002/api/getUserRequest/'.$id);
        return Inertia::render('Integrations/OneClickVid/Show',[
            'id'=>$id,
            'request'=>$request->json()
        ]);
    }

    
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
