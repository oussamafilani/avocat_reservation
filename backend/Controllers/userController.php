<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

class userController
{

    // User Properties
    private $database;
    private $db;
    private $User;
    private $chekToken;

    // Get raw posted data


    public function __construct()
    {
        // Instantiate DB & connect
        $this->database = new Connect();
        $this->db = $this->database->connect();
        // Instantiate Appointment object
        $this->User = new User($this->db);
        $this->data  = json_decode(file_get_contents("php://input"));
    }

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

    public function createUser()
    {

        $this->User->token = self::generateToken();
        $this->User->nom_client = $this->data->nom_client;
        $this->User->prenom_client = $this->data->prenom_client;
        $this->User->profession = $this->data->profession;
        $this->User->age_client = $this->data->age_client;
        $this->User->cin = $this->data->cin;


        // Create User


        if (!$this->User->CheckCin()) {
            if ($this->User->Register()) {
                echo json_encode(
                    array('message' => 'User Created')
                );
            } else {
                echo json_encode(
                    array('message' => 'User Not Created')
                );
            }
        } else {
            echo json_encode(
                array('message' => 'Cin Already Exist')
            );
        }
    }
    public function getUserInfo()
    {
    }
    public function readUser()
    {
    }
}
