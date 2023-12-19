<?php


namespace App\Repositories\GoGetLead;

use App\Actions\UpdateWallet;
use App\Http\Resources\ProductResource;
use App\Models\Integrable;
use App\Models\Integration;
use App\Models\IntegrationPayment;
use App\Models\Investor;
use App\Models\Scopes\IntegrationScope;
use App\Models\User;
use App\Notifications\WalletNotification;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Exception;
use App\Http\Traits\Crypt;
use Illuminate\Support\Facades\Notification;

class IntegrationRepository
{
    use Crypt;
    public function checkToken($request)
    {
        $tokenInfo = PersonalAccessToken::findToken($request->bearerToken());
        if ($tokenInfo) {
            $user = User::find($tokenInfo->tokenable_id);
            if ($user) {
                $roles=$user->getRoleNames()->toArray();
                if(in_array('Investor',$roles)) $this->checkGogetLeadIntegration($user);
                return response()->json([
                    'statut' => 'success', 
                    'message' => 'Connected Successfully', 
                    'investor' => $this->encrypt_decrypt('encrypt', in_array('Investor',$roles) ? $user->investor->id :null , 'Investor Id'),
                    'seller' => $this->encrypt_decrypt('encrypt', in_array('Seller',$roles) ? $user->seller->id :null , 'Seller Id'),
                    'roles'=>$roles
                ], 200);
            } else return response()->json(['statut' => 'error', 'message' => 'Connection Failed'], 403);
        } else return response()->json(['statut' => 'error', 'message' => 'Connection Failed'], 403);
    }

    public function userTokenProducts()
    {
        $roles=request()->user()->getRoleNames()->toArray();

        if((in_array('Investor',$roles) && in_array('Seller',$roles))) {
            return response()->json([
                'seller_products'=>ProductResource::collection(request()->user()->seller->products),
                'investor_products'=>ProductResource::collection(request()->user()->investor->accessProducts)
            ],200);
        }
        else if(in_array('Investor',$roles))
        {
            return response()->json([
                'seller_products'=>[],
                'investor_products'=>ProductResource::collection(request()->user()->investor->accessProducts)
            ],200);
        }
        else if(in_array('Seller',$roles)){
            return response()->json([
                'seller_products'=>ProductResource::collection(request()->user()->seller->products),
                'investor_products'=>[]
            ],200);
        }
    }

    public function productDetails($id)
    {
        return response()->json(new ProductResource(Auth::user()->investor->accessProducts->where('id', $id)->first()), 200);
    }

    public function createOrders($request)
    {
        try {
            $investor = Auth::user()->investor;
            $product = $investor->accessProducts->where('id', $request->product)->first();

            $order = $investor->orders()->create([
                'customer_name'              => $request->customer_name,
                'phone'                      => $request->customer_phone,
                'customer_city'              => $request->customer_city,
                'product_name'               => $product->sku,
                'country'                    => $request->customer_country == null ? 'Local Country' : $request->customer_country,
                'website'                    => $request->website,
                'price'                      => $request->price,
                'status'                     => 'pending',
                'product_link'               => isset($product) ? (isset($product->pivot->link) != null ? $product->pivot->link : $product->website_link) : null,
                'product_id'                 => isset($product) ? $product->id : null,
                'commission'                 => isset($product) ? $product->pivot->affiliate_commission : 0,
                'source'                     => 'GoGetLead',
                'pricings'                   => $product->pivot->pricings,
                'foreign_order_id'           => $request->order_id
            ]);

            if ($order) return response()->json(['message' => 'Transferred'], 200);
            else  return response()->json(['message' => 'Not Transferred'], 403);
        } catch (Exception $e) {
            return response()->json(['message' => 'Not Transferred'], 403);
        }
    }

    public function checkGogetLeadIntegration($user)
    {
        $investor = $user->investor;
        $myintegration = $investor->integrations()->withoutGlobalScope(IntegrationScope::class)->where('name', 'GoGetLead')->first();

        if ($myintegration) {
            return $myintegration->pivot;
        } else {
            $integration = Integration::where('name', 'GoGetLead')->withoutGlobalScope(IntegrationScope::class)->first();
            $integrable = Integrable::create([
                'integration_id' => $integration->id,
                'integrable_id' => $investor->id,
                'integrable_type' => $investor->getMorphClass()
            ]);
            return $integrable;
        }
    }

    public function transferBalance($request)
    {
        $user = Auth::user();
        $integrable = $this->checkGogetLeadIntegration($user);
        if ($this->currentBalance($user->investor) >= $request->transfer_value) {
            $integrationPayment = IntegrationPayment::create([
                'integration_id' => $integrable->integration_id,
                'integrable_id' => $request->user()->investor->id,
                'integrable_type' => $request->user()->investor->getMorphClass(),
                'amount' => $request->transfer_value,
                'payment_info' => 'Transfer of ' . $request->transfer_value . '$ from CodInvestor to GOGetLead',
                'status' => 'pending'
            ]);

            if ($integrationPayment) {
                (new UpdateWallet())->execute($user->investor);
                $user->notify(new WalletNotification('Transfer of ' . $request->transfer_value . '$ from CodInvestor to GOGetLead'));
                return response()->json(['message' => 'success'], 200);
            } else return response()->json(['message' => 'error'], 403);
        } else return response()->json(['message' => 'error'], 403);
    }

    public function currentBalance($investor)
    {
        return $investor?->wallet;
    }
}
