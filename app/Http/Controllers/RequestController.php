<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCreativeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Traits\Crypt;
use App\Repositories\RequestRepository;
use Illuminate\Support\Facades\Redirect;

class RequestController extends Controller
{
    use Crypt;
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
        $token=PersonalAccessToken::where('tokenable_id', Auth::user()->investor->id)->orderby('created_at', 'desc')->first('name');
        
        $requests=Http::withToken($token->name)->get('https://adminapp.oneclickvid.com/api/getUserRequests');

        return response()->json($requests->json());
    }

    public function userequest($id)
    {
        $token=PersonalAccessToken::where('tokenable_id', Auth::user()->investor->id)->orderby('created_at', 'desc')->first('name');
        
        $requests=Http::withToken($token->name)->get('https://adminapp.oneclickvid.com/api/getUserRequest'.$id);

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
