<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../Models/Connect.php';
include_once '../../Models/Appointment.php';

// Instantiate DB & connect
$database = new Connect();
$db = $database->connect();

// Instantiate Appointment object
$Appointment = new Appointment($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to delete
$Appointment->id_appointment = $data->id_appointment;

// Delete Appointment
if ($Appointment->delete()) {
    echo json_encode(
        array('message' => 'Appointment Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Appointment Not Deleted')
    );
}
