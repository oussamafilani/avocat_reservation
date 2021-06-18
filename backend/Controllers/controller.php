<?php
class Controller
{

    static public function generateToken()
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
        $token =  $randomnumber . '/' . $randomString . '/' . $ran;

        // $password = password_hash($token, PASSWORD_DEFAULT);
        return $token;
    }
}





echo Controller::generateToken();
