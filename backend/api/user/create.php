<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../Models/Connect.php';
include_once '../../Models/User.php';
include_once '../../Controllers/Controller.php';

// Instantiate DB & connect
$database = new Connect();
$db = $database->connect();


// Instantiate User object
$User = new User($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$User->token = Controller::generateToken();
$User->nom_client = $data->nom_client;
$User->prenom_client = $data->prenom_client;
$User->profession = $data->profession;
$User->age_client = $data->age_client;
$User->cin = $data->cin;


// Create User


if (!$User->CheckCin()) {
    if ($User->Register()) {
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
