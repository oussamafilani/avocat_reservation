<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../Models/Connect.php';
include_once '../../Models/Appointment.php';

// Instantiate DB & connect
$database = new Connect();
$db = $database->connect();

// Instantiate Appointment object
$post = new Appointment($db);

// Appointment query
$result = $post->read();
// Get row count
$num = $result->rowCount();

// Check if any Appointment
if ($num > 0) {
    // Post array
    $posts_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id_appointment' => $id_appointment,
            'date' => $date,
            'sujet' => $sujet,
            'id_creneaux' => $id_creneaux,
            'id_client' => $id_client,
        );

        // Push to "data"
        array_push($posts_arr, $post_item);
    }

    // Turn to JSON & output
    echo json_encode($posts_arr);
} else {
    // No Appointment
    echo json_encode(
        array('message' => 'No Appointment Found')
    );
}
