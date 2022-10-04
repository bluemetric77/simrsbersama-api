<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;

define('STARTKEY','1Lk5Uz3slx3BrAghS1aaW5AYgWZRV0tIX5eI0yPchFz4=');
define('ENDKEY','1EZ44mFi3TlAey1b2w4Y7lVDuqO+SRxGXsa7nctnr/JmMrA2vN6EJhrvdVZbxaQs5jpSe34X3ejFK/o9+Y5c83w==');

class Encrypt
{
    function secured_encrypt($data,$password='')
    {
        $first_key = base64_decode(STARTKEY).$password;
        $second_key = base64_decode(ENDKEY);   

        $method = "aes-256-cbc";   
        $iv_length = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($iv_length);
            
        $first_encrypted = openssl_encrypt($data,$method,$first_key, OPENSSL_RAW_DATA ,$iv);   
        $second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
                
        $output = base64_encode($iv.$second_encrypted.$first_encrypted);   
        return $output;       
    }
    function secured_decrypt($input,$password='')
    {
        $first_key = base64_decode(STARTKEY).$password;
        $second_key = base64_decode(ENDKEY);           
        $mix = base64_decode($input);
            
        $method = "aes-256-cbc";   
        $iv_length = openssl_cipher_iv_length($method);
                
        $iv = substr($mix,0,$iv_length);
        $second_encrypted = substr($mix,$iv_length,64);
        $first_encrypted = substr($mix,$iv_length+64);
                
        $data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);
        $second_encrypted_new = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
        
        if (hash_equals($second_encrypted,$second_encrypted_new))
        return $data;
        return false;
    }    
}
