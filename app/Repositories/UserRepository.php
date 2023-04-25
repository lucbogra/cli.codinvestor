<?php

namespace App\Repositories;

use App\Models\Integration;
use App\Models\Investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\Crypt;
use App\Models\Integrable;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
  use Crypt;

  public function create_oneclickvid(Request $request)
  {
    // dd($request->all());
    $investor=Investor::findorfail($request->id);
      
      $id = $this->encrypt_decrypt('encrypt', $request->id, 'Create an Account on One Click Vid');
      $type = $this->encrypt_decrypt('encrypt', $request->type, 'Create an Account on One Click Vid');
      $id_integration = $this->encrypt_decrypt('encrypt', $request->id_integration, 'Create an Account on One Click Vid');
      $name = $this->encrypt_decrypt('encrypt', $request->name, 'Create an Account on One Click Vid');
      $email = $this->encrypt_decrypt('encrypt', $request->email, 'Create an Account on One Click Vid');
      $password = $this->encrypt_decrypt('encrypt', $request->password, 'Create an Account on One Click Vid');

      // dd('http://127.0.0.1:8002/api/create/user/'.$id.'/'.$type.'/'. $name .'/'.$email.'/'.$password);
      $response=Http::withHeaders([
        'Accept' => 'application/json'
      ])->timeout(60)->post('https://adminapp.oneclickvid.com/api/create/user/'.$id.'/'.$type.'/'. $name .'/'.$email.'/'.$password);
      // $response=Http::withHeaders([
      //   'Accept' => 'application/json'
      // ])->timeout(60)->post('http://127.0.0.1:8002/api/create/user/'.$id.'/'.$type.'/'. $name .'/'.$email.'/'.$password);
      
      $message=json_decode($response->getBody()->getContents());
      
      
      if($message->message=='success')
      {

          $integration=Integration::findorfail($request->id_integration);
        
          $investor = Investor::find($request->id);
        
          $integrable=Integrable::where('integrable_type',$investor->getMorphClass())
                                ->where('integration_id',$integration->id)
                                ->where('integrable_id',$investor->id)
                                ->count();
          if($integrable==0)
          {
            Integrable::Create([
              'integration_id'=>$integration->id,
              'integrable_type'=>$investor->getMorphClass(),
              'integrable_id'=>$investor->id,
              'token'=>$message->token
            ]);
          }

        return back()->with('success','Integrated Successfully');
      }
      else if($message->message=='exists')
      {
        return back()->with('error','Email Already Exists In This Integration');
      }
      else{

        return back()->with('error','Error Integration');
      }
    
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
