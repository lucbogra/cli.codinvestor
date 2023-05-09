<?php

namespace App\Http\Controllers\OneClickVid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RequestCreativeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Traits\Crypt;
use App\Http\Traits\Url;
use App\Models\Integrable;
use App\Repositories\OneClickVid\RequestRepository;
use Illuminate\Support\Facades\Redirect;
class RequestController extends Controller
{
    use Crypt;
    use Url;
    protected  $investor;
    protected $requestrepository;

    public function __construct(RequestRepository $requestrepository)
    {
        $this->requestrepository=$requestrepository;
        // $this->middleware(function ($request, $next) {
        //     $this->investor = $request->user()->hasRole('Investor') ? $request->user()->investor : ($request->user()->hasRole('Member') ? $request->user()->member->investor : null);
        //     return $next($request);
        // });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Inertia::render('Requests/Index', [
        //     'products' => $this->investor->products()
        // ]);
    }

    public function create()
    {
        //
    }

    public function store(RequestCreativeRequest $request)
    {
        // dd($request->all());
        $this->requestrepository->store($request);
        return back()->with('success', 'Request Created successfully');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
         $this->requestrepository->update($request,$id);

        return back()->with('success', 'Request Updated successfully');
    }

   
    public function destroy($id)
    {
        return $this->requestrepository->destroy($id);
    }

    public function userequests()
    {
        
        $requests=Http::withToken($this->token())->get($this->link().'/api/getUserRequests');
        //  $requests=Http::withToken($integrable->token)->get('http://127.0.0.1:8002/api/getUserRequests');
        // return $requests->json();
        
        if($requests->json()['message']==='error')
        {
            return response()->json([]);   
        }
        else
        {
            return response()->json($requests->json()['data']);
        }
        
    }

    public function userequest($id)
    {
        $requests=Http::withToken($this->token())->get($this->link().'/api/getUserRequest'.$id);
        // $requests=Http::withToken($integrable->token)->get('http://127.0.0.1:8002/api/getUserRequest'.$id);

        return response()->json($requests->json());
    }

    public function rate(Request $request,$id)
    {
        $this->requestrepository->Rate($request,$id);

        return back()->with('success', 'Rated successfully');
    }

    public function getCreativesNotification($id,$id_user,$message,$route)
    {
        return $this->requestrepository->getCreativesNotification($id,$id_user,$message,$route);
    }
}
