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
  // function encrypt_decrypt($action, $string)
  // {
  //   $output = false;
  //   $encrypt_method = "AES-256-CBC";
  //   $secret_key = 'Create an Account on One Click Vid';
  //   $secret_iv = '1234567845678321';

  //   // hash the key
  //   $key = hash('sha256', $secret_key);

  //   // create iv
  //   $iv = substr(hash('sha256', $secret_iv), 0, 16);

  //   if ($action == 'decrypt') {
  //     $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  //   } else if ($action == 'encrypt') {
  //     $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
  //     $output = base64_encode($output);
  //   }

  //   return $output;
  // }

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

      // dd('http://127.0.0.1:8002/api/create/user/'.$id.'/'.$type.'/'. $name .'/'.$email.'/'.$password);
      $response=Http::timeout(60)->post('http://127.0.0.1:8002/api/create/user/'.$id.'/'.$type.'/'. $name .'/'.$email.'/'.$password);

      // dd($response->json());
      if($response->getStatusCode()==500)
      {
          $investor->integrations()->save($integration);

          return back()->with('success','Integrated Successfully');
      }
      else
      {
          return back()->with('error','Error In Integration Successfully'); 
      }
    
  }

  public function user_token($id, $token)
  {
    $id_decrypted = $this->encrypt_decrypt('decrypt',$id, 'Create an Account on One Click Vid');
    $token_decrypted  = $this->encrypt_decrypt('decrypt',$token, 'Create an Account on One Click Vid');
    
    $investor = Investor::find((int)$id_decrypted);
    
    $investor->createToken($token_decrypted)->accessToken;

    
  }

  public function company()
  {
  }
}
