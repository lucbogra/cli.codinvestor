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
use App\Models\Product;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class IntegrationController extends Controller
{
    public function createToken(Request $request,$name)
    {
        return  $request->user()->createToken($name,['read'])->plainTextToken;
    }

    public function checkToken(Request $request)
    {
        $tokenInfo = PersonalAccessToken::findToken($request->bearerToken());
        if ($tokenInfo) {
            $user = Auth::user();

            if ($user) return response(['statut' => 'success', 'message' => 'Connected Successfully']);
            else return response(['statut' => 'error', 'message' => 'Connection Failed']);
        } else return response(['statut' => 'error', 'message' => 'Connection Failed']);
    }

    public function UserTokenProducts(Request $request)
    {
        $user=Auth::user();
        return response()->json(ProductResource::collection($user->investor->accessProducts));
    }

    public function ProductDetails($id)
    {   
        
        return response()->json(new ProductResource(Product::find($id)));
    }
}
