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



class appointmentController
{
}
