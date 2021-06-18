<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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

// Set ID to update
$Appointment->id_appointment = $data->id_appointment;


$Appointment->token = $data->token;
$Appointment->date = $data->date;
$Appointment->sujet = $data->sujet;
$Appointment->id_creneaux = $data->id_creneaux;

// Update post
if ($Appointment->update() == "9") {
    echo json_encode(
        array('message' => 'Appointment Updated')
    );
} elseif ($Appointment->update() === "no valid") {
    echo json_encode(
        array('message' => 'No Valid')
    );
} else {
    echo json_encode(
        array('message' => 'Appointment Not Updated')
    );
}
