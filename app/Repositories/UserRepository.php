<?php

namespace App\Repositories;

use App\Models\Integration;
use App\Models\Investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\Crypt;
use App\Http\Traits\Url;
use App\Models\Integrable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use function PHPSTORM_META\type;

class UserRepository
{
  use Crypt;
  use Url;

  public function create_oneclickvid(Request $request)
  {
    
    if($request->type==='Create')
    {
      $request->validate([
        'subscribe'=>'required',
        'platforms'=>"required",
        'leads'=>"required",
        'cpl'=> "required",
        'similar_service'=>"required",
        'service_observation'=> 'nullable',
        'others_observation'=>'nullable'
      ]);

      $email = $this->encrypt_decrypt('encrypt', $request->user()->email, 'Create an Account on One Click Vid');
      $password = $this->encrypt_decrypt('encrypt', $request->user()->password , 'Create an Account on One Click Vid');
    }
    else{
      $email = $this->encrypt_decrypt('encrypt', $request->email, 'Create an Account on One Click Vid');
      $password = $this->encrypt_decrypt('encrypt', $request->password, 'Create an Account on One Click Vid');
    }
      
      $id = $this->encrypt_decrypt('encrypt', $request->user()->investor->id, 'Create an Account on One Click Vid');
      $type = $this->encrypt_decrypt('encrypt', $request->type, 'Create an Account on One Click Vid');
      $id_integration = $this->encrypt_decrypt('encrypt', $request->id_integration, 'Create an Account on One Click Vid');
      $name = $this->encrypt_decrypt('encrypt', $request->name==null ? $request->user()->name : $request->name, 'Create an Account on One Click Vid');
      $leads = $this->encrypt_decrypt('encrypt',$request->leads, 'Create an Account on One Click Vid');
      $application = $this->encrypt_decrypt('encrypt','CODINVESTOR', 'Create an Account on One Click Vid');
      $cpl = $this->encrypt_decrypt('encrypt', $request->cpl, 'Create an Account on One Click Vid');
      $similar_service = $this->encrypt_decrypt('encrypt', $request->similar_service, 'Create an Account on One Click Vid');
      $service_observation = $this->encrypt_decrypt('encrypt', $request->service_observation, 'Create an Account on One Click Vid');
      $others_observation = $this->encrypt_decrypt('encrypt', $request->others_observation, 'Create an Account on One Click Vid');
      
       $response=Http::timeout(60)->post($this->link().'/api/createAccountOneClick',[
        'id'=>$id,
        'type'=>$type,
        'name'=>$name,
        'email'=>$email,
        'password'=>$password,
        'subscribe'=>serialize($request->subscribe),
        'platforms'=>serialize($request->platforms),
        'leads'=>$leads,
        'cpl'=>$cpl,
        'similar_service'=>$similar_service,
        'service_observation'=>$service_observation,
        'others_observation'=>$others_observation,
        'application'=>$application
      ]);
    
      $message=json_decode($response->getBody()->getContents());
      if($message->message=='success')
      {
          $integration=Integration::findorfail($request->id_integration);
        
            Integrable::Create([
              'integration_id'=>$integration->id,
              'integrable_type'=>$request->user()->investor->getMorphClass(),
              'integrable_id'=>$request->user()->investor->id,
              'token'=>$message->token
            ]);

        return redirect()->route('oneclickvid.index')->with('success','Integrated Successfully');
      }
      else if($message->message=='exists') return back()->with('error','Email Already Exists In This Integration');
      
      else if($message->message=='Password Incorrect') return back()->with('error','Password Incorrect');
      
      else return back()->with('error','Error Integration');
      
    
  }

  public function user_token($request)
  {

    $id_decrypted = $this->encrypt_decrypt('decrypt',$request->id, 'Create an Account on One Click Vid');
    $token_decrypted  = $this->encrypt_decrypt('decrypt',$request->token, 'Create an Account on One Click Vid');
    $id_integration = $this->encrypt_decrypt('decrypt', $request->id_integration, 'Create an Account on One Click Vid');

    //  dd([$id_decrypted,$token_decrypted,$id_decrypted]);
    $integration=Integration::findorfail($id_integration);
    
    $investor = Investor::find((int)$id_decrypted);
    
    $integrable=Integrable::where('integrable_type',$investor->getMorphClass())
                            ->where('integration_id',$integration->id)
                            ->where('integrable_id',$investor->id)
                            ->first();
    if($integrable){
      $integrable->update([
        'integration_id'=>$integration->id,
        'integrable_type'=>$investor->getMorphClass(),
        'integrable_id'=>$investor->id,
        'token'=>$token_decrypted
      ]);
    }
    else
    {
      Integrable::Create([
        'integration_id'=>$integration->id,
        'integrable_type'=>$investor->getMorphClass(),
        'integrable_id'=>$investor->id,
        'token'=>$token_decrypted
      ]);
    }
    

    return response()->json(['message' => 'success'], 200);
  }

  public function company()
  {
  }
}
