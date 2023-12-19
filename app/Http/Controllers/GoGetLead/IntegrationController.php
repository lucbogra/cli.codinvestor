<?php

namespace App\Http\Controllers\GoGetLead;

use App\Models\User;
use App\Repositories\GoGetLead\IntegrationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Integrable;
use App\Models\Integration;
use App\Models\Order;
use App\Models\Product;
use App\Models\Scopes\IntegrationScope;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class IntegrationController extends Controller
{

    private $integrationrepository;

    public function __construct(IntegrationRepository $integrationRepository)
    {
        $this->integrationrepository=$integrationRepository;
    }
    public function createToken(Request $request, $name)
    {
        if(empty(str_replace(' ', '', $name))) return response()->json(null,422);
        else return response()->json($request->user()->createToken($name, ['read'])->plainTextToken);
    }

    public function checkToken(Request $request)
    {
        return $this->integrationrepository->checkToken($request);
    }

    public function userTokenProducts()
    {
        return $this->integrationrepository->userTokenProducts();
    }

    public function productDetails($id)
    {
        return $this->integrationrepository->productDetails($id);
    }

    public function createOrders(Request $request)
    {
        return $this->integrationrepository->createOrders($request);
    }

    public function getBalance()
    {
        return response()->json($this->integrationrepository->currentBalance(Auth::user()->investor),200);
    }

    public function transferBalance(Request $request)
    {
        return $this->integrationrepository->transferBalance($request);
    }

    public function getRole(Request $request)
    {
        return [
            'roles'=>$request->user()->getRoleNames()->toArray(),
            'investor'=>$request->user()->investor?->id,
            'seller'=>$request->user()->seller?->id
        ];
    }
}
