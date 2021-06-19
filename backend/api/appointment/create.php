<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../Models/Connect.php';
include_once '../../Models/Appointment.php';

// Instantiate DB & connect
$database = new Connect();
$db = $database->connect();


// Instantiate Appointment object
$Appointment = new Appointment($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//check  token
$Appointment->token = $data->token;
$chekToken = $Appointment->CheckToken();

$Appointment->date = $data->date;
$Appointment->sujet = $data->sujet;
$Appointment->id_creneaux = $data->id_creneaux;
$Appointment->id_client = $data->id_client;

// Create Appointment
if ($Appointment->create()) {
    echo json_encode(
        array('message' => 'Appointment Created')
    );
} else {
    echo json_encode(
        array('message' => 'Appointment Not Created')
    );
}
