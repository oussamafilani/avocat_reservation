<?php

// //Generate a random string.
// $token = openssl_random_pseudo_bytes(2);

// //Convert the binary data into hexadecimal representation.
// $token = bin2hex($token);

// //Print it out for example purposes.
// // echo $token;
// $a =  $token;
// $b = rand(100000, 999999);

// echo $b . '/' . $a;

function generateRandomString($length = 10)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


echo generateRandomString(4);


// function generateRandomString($length = 10) {
//     return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
// }

// echo  generateRandomString();  // OR: generateRandomString(24)