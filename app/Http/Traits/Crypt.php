<?php

namespace App\Http\Traits;

trait Crypt{
    function encrypt_decrypt($action, $string,$key)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = $key;
        $secret_iv = '1234567845678321';

        // hash the key
        $key = hash('sha256', $secret_key);

        // create iv
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        } else if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }

        return $output;
    }
}