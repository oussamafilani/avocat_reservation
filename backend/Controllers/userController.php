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
    private $contentType;


    // Get raw posted data


    public function __construct()
    {
        // check sontent type
        $this->contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';
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
        $this->User->age_client = $this->data->profession;
        $this->User->cin = $this->data->cin;

        //check if the data not emty
        if (
            !empty($this->data->nom_client)
            && !empty($this->data->prenom_client)
            && !empty($this->data->profession)
            && !empty($this->data->profession)
            && !empty($this->data->cin)
        ) {
            if (!$this->User->CheckCin()) {
                // Create User

                if ($this->User->Register()) {
                    echo json_encode(
                        array('message' => $this->User->token)
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
        } else {
            echo json_encode(
                array('message' => 'please fill in the blank')
            );
        }
    }
    public function getUserInfo()
    {

        //check  token
        $this->User->token = $this->data->token;
        $this->chekToken = $this->User->CheckToken();

        $this->User->id_client = $this->User->getIdClientFromToken();

        // User query
        $result = $this->User->getInfo();
        // Get row count
        $num = $result->rowCount();

        // Check if any User
        if ($this->chekToken) {
            if ($num > 0) {
                // Post array
                $posts_arr = array();
                $appointment_data = array();

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    $client_info = ['client_info' => array(
                        'nom_client' => $nom_client,
                        'prenom_client' => $prenom_client,
                        'profession' => $profession,
                        'age_client' => $age_client,
                        'cin' => $cin,
                    )];

                    $post_item = array(
                        'id_appointment' => $id_appointment,
                        'date' => $date,
                        'sujet' => $sujet,
                        'd_hour' => $d_hour,
                        'f_hour' => $f_hour,
                    );

                    // Push to "data"
                    array_push($appointment_data, $post_item);
                }
                $client_info['client_info']['appointments'] = $appointment_data;

                array_push($posts_arr, $client_info);

                // Turn to JSON & output
                echo json_encode($posts_arr);
            } else {
                // No User
                echo json_encode(
                    array('message' => 'No User Found')
                );
            }
        } else {
            echo json_encode(
                array('message' => 'Token Not Valid')
            );
        }
    }

    // Get singel client info
    public function getSingleClient()
    {
        //check  token
        $this->User->token = $this->data->token;
        $this->chekToken = $this->User->CheckToken();

        $this->User->id_client = $this->User->getIdClientFromToken();
        $result = $this->User->getSingleClient();
        $num = $result->rowCount();

        if ($num > 0) {

            $row = $result->fetch(PDO::FETCH_ASSOC);

            extract($row);
            $posts_arr = array();
            $post_item = array(
                'id_client' => $id_client,
                'nom_client' => $nom_client,
                'prenom_client' => $prenom_client,
                'profession' => $profession,
                'age_client' => $age_client,
                'cin' => $cin,
                'id_user' => $id_user,
            );
            // Push to "data"
            array_push($posts_arr, $post_item);
            // Turn to JSON & output
            echo json_encode($posts_arr);
        } else {
            // No User
            echo json_encode(
                array('message' => 'No User Found')
            );
        }
    }
    public function readUser()
    {

        // User query
        $result = $this->User->read();
        // Get row count
        $num = $result->rowCount();

        // Check if any User
        if ($num > 0) {
            // Post array
            $posts_arr = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $post_item = array(
                    'id_client' => $id_client,
                    'nom_client' => $nom_client,
                    'prenom_client' => $prenom_client,
                    'profession' => $profession,
                    'age_client' => $age_client,
                    'cin' => $cin,
                    'id_user' => $id_user,
                );

                // Push to "data"
                array_push($posts_arr, $post_item);
            }

            // Turn to JSON & output
            echo json_encode($posts_arr);
        } else {
            // No User
            echo json_encode(
                array('message' => 'No User Found')
            );
        }
    }
}
