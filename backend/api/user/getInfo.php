<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
// header('Access-Control-Allow-Methods: POST');
// header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../Models/Connect.php';
include_once '../../Models/User.php';

// Instantiate DB & connect
$database = new Connect();
$db = $database->connect();

// Instantiate User object
$User = new User($db);

// User query
$result = $User->read();
// Get row count
$num = $result->rowCount();

// Check if any User
if ($num > 0) {
    // Post array
    $posts_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'nom_client' => $nom_client,
            'prenom_client' => $prenom_client,
            'profession' => $profession,
            'age_client' => $age_client,
            'cin' => $cin,
            "appointment" => array(
                "id_appointment" => $id_appointment,
                "date" => $date,
                "sujet" => $sujet,
                "d_hour" => $d_hour,
                "d_fin" => $d_fin,
            )
        );

        // SELECT client.id_client,client.nom_client,client.prenom_client,client.profession,client.age_client,client.cin,
        // appointment.id_appointment,appointment.date,appointment.sujet,
        // creneaux.d_hour,creneaux.f_hour
        // FROM appointment
        // INNER JOIN client on client.id_client = appointment.id_client
        // INNER JOIN creneaux on creneaux.id_creneaux = appointment.id_creneaux


        // Push to "data"
        array_push($posts_arr, $post_item);
    }

    // Turn to JSON & output
    echo json_encode($posts_arr);
} else {
    // No Appointment
    echo json_encode(
        array('message' => 'No Client Info  Found')
    );
}
