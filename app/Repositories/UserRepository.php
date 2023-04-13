<?php

namespace App\Repositories;

use App\Models\Integration;
use App\Models\Investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\Crypt;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
  use Crypt;

  public function create_oneclickvid(Request $request)
  {
    // dd($request->all());
    $investor=Investor::findorfail($request->id);
      $integration=Integration::findorfail($request->id_integration);
      $id = $this->encrypt_decrypt('encrypt', $request->id, 'Create an Account on One Click Vid');
      $type = $this->encrypt_decrypt('encrypt', $request->type, 'Create an Account on One Click Vid');
      $name = $this->encrypt_decrypt('encrypt', $request->name, 'Create an Account on One Click Vid');
      $email = $this->encrypt_decrypt('encrypt', $request->email, 'Create an Account on One Click Vid');
      $password = $this->encrypt_decrypt('encrypt', $request->password, 'Create an Account on One Click Vid');

       //dd('http://127.0.0.1:8002/api/create/user/'.$id.'/'.$type.'/'. $name .'/'.$email.'/'.$password);
      $response=Http::timeout(60)->post('https://adminapp.oneclickvid.com/api/create/user/'.$id.'/'.$type.'/'. $name .'/'.$email.'/'.$password);
      // $response=Http::timeout(60)->post('http://127.0.0.1:8002/api/create/user/'.$id.'/'.$type.'/'. $name .'/'.$email.'/'.$password);
      $body=json_decode($response->getBody()->getContents());
       
      if($body->message==='Success')
      {
          $investor->integrations()->save($integration);

          return back()->with('success','Integrated Successfully');
      }
      else
      {
          return back()->with('error','Error In Integration'); 
      }
    
  }

  public function user_token($id, $token)
  {

    $id_decrypted = $this->encrypt_decrypt('decrypt',$id, 'Create an Account on One Click Vid');
    $token_decrypted  = $this->encrypt_decrypt('decrypt',$token, 'Create an Account on One Click Vid');
    
    
    $investor = Investor::find((int)$id_decrypted);
    
    
    $investor->createToken($token_decrypted);

    //dd($investor->createToken($token_decrypted)->plaintexttoken);
  }

  public function company()
  {
  }
}
