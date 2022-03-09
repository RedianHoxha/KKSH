<?php

function encryptValues($string){

    // Store cipher method
    $ciphering = "AES-128-CTR";

    // Use OpenSSl encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

    // Use random_bytes() function which gives
    // randomly 16 digit values
    $encryption_iv = '1234567891011121';

    // Alternatively, we can use any 16 digit
    // characters or numeric for iv
    $encryption_key = 'KKSHEOC';

    // Encryption of string process starts
    $encryption = openssl_encrypt($string, $ciphering,
    $encryption_key, $options, $encryption_iv);
    return $encryption;
}


function decrypt($string){

     // Store cipher method
     $ciphering = "AES-128-CTR";
  
    // Use OpenSSl encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    
    // Use random_bytes() function which gives
    // randomly 16 digit values
    $encryption_iv = '1234567891011121';

    // Store the decryption key
    $decryption_key ='KKSHEOC';
    
    // Descrypt the string
    $decryption = openssl_decrypt ($string, $ciphering,
                $decryption_key, $options, $encryption_iv);


    return $decryption;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>
