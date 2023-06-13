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
use App\Http\Traits\Url;
use App\Models\Invoice;
use Laravel\Sanctum\PersonalAccessToken;

class IntegrationController extends Controller
{
    use Url;
    public $integrationRepository;

    private $investor;

    public function __construct(IntegrationRepository $integrationRepository)
    {
        $this->middleware(function ($request, $next) {
            $this->investor = $request->user()->hasRole('Investor') ? $request->user()->investor : ($request->user()->hasRole('Member') ? $request->user()->member->investor : null);
            return $next($request);
        });
        $this->integrationRepository = $integrationRepository;
    }

    public function index()
    {
            $data= $this->integrationRepository->integrationData($this->investor);
            
            return Inertia::render('Integrations/Index', [
                'integration_user' => IntegrationResource::collection($data['userIntegration']),
                'integrations' => $data['integration'],
            ]);
    }

    public function oneclickVid()
    {
        $remain=0;
        $investorPayments=$this->investor->pendingIntegrationPayment()->get();
        foreach($investorPayments as $payment)
        {
            $remain+=$payment->remain;
        }
        $integrable = Integrable::where('integrable_id', Auth::user()->investor->id)
            ->where('integrable_type', 'App\Models\Investor')
            ->wherehas('integration', function (Builder $builder) {
                $builder->where('name', 'One Click Vid');
            })->first();

        if ($integrable) {
            return Inertia::render('Integrations/OneClickVid/Index', [
                'hasIntegrationPayment' => count($this->investor->pendingIntegrationPayment) > 0,
                'investorRemain'=>$remain 
            ]);
        } else  return  redirect()->route('integrations.index');
    }

    public function request_show($id)
    {
        Notification::wherejsoncontains('data->id', $id)->update(['read_at' => now()]);
        $integrable = Integrable::where('integrable_id', Auth::user()->investor->id)
            ->where('integrable_type', 'App\Models\Investor')->first('token');
        $request = Http::withToken($integrable->token)->get($this->link() . '/api/getUserRequest/' . $id);
        return Inertia::render('Integrations/OneClickVid/Show', [
            'id' => $id,
            'request' => $request->json()
        ]);
    }

    public function logout(Integration $integration)
    {
        $checkConnected = $this->integrationRepository->logout($integration, $this->investor);

        return $checkConnected ? redirect()->route('oneclickvid.index')->with('success', 'Connected Successfully') : back()->with('success', 'Logout Successfully');
    }
}
