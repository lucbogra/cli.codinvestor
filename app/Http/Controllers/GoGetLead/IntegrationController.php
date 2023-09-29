<?php

namespace App\Http\Controllers\GoGetLead;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class IntegrationController extends Controller
{
    public function createToken(Request $request, $name)
    {
        return  $request->user()->createToken($name, ['read'])->plainTextToken;
    }

    public function checkToken(Request $request)
    {
        $tokenInfo = PersonalAccessToken::findToken($request->bearerToken());
        if ($tokenInfo) {
            $user = User::find($tokenInfo->tokenable_id);
            if ($user) return response(['statut' => 'success', 'message' => 'Connected Successfully']);
            else return response(['statut' => 'error', 'message' => 'Connection Failed']);
        } else return response(['statut' => 'error', 'message' => 'Connection Failed']);
    }

    public function UserTokenProducts()
    {
        return response()->json(ProductResource::collection(Auth::user()->investor->accessProducts));
    }

    public function ProductDetails($id)
    {
        return response()->json(new ProductResource(Auth::user()->investor->accessProducts->where('id',$id)->first()));
    }

    public function CreateOrders(Request $request)
    {
        
        $investor = Auth::user()->investor;
        $product = $investor->accessProducts->where('id',$request->product)->first();
        
        $order = $investor->orders()->create([
            'customer_name'              => $request->customer_name,
            'phone'                      => $request->customer_phone,
            'customer_city'              => $request->customer_city,
            'product_name'               => $product->sku,
            'country'                    => $request->customer_country,
            'website'                    => $request->website,
            'price'                      => $request->price,
            'status'                     => 'pending',
            'product_link'               => isset($product) ? (isset($product->pivot->link) != null ? $product->pivot->link : $product->website_link) : null,
            'product_id'                 => isset($product) ? $product->id : null,
            'commission'                 => isset($product) ? $product->pivot->affiliate_commission : 0,
            'source'                     => 'GoGetLead',
            'pricings'                   => $product->pivot->pricings,
            'foreign_order_id'           =>$request->order_id
        ]);

        if ($order) {
            return response()->json('success');
        } else {
            return response()->json('error');
        }
    }
}
