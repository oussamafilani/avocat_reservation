<?php


function generateToken()
{
    //Generate a random string.
    $ran = openssl_random_pseudo_bytes(1);

    //Convert the binary data into hexadecimal representation.
    $ran = bin2hex($ran);

    //Generate Random number from 100000 to 999999
    $randomnumber = rand(100000, 999999);

    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 4; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomnumber . '/' . $randomString . '/' . $ran;
}


echo generateToken();
