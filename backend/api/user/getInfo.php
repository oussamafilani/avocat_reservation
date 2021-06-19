<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../Models/Connect.php';
include_once '../../Models/User.php';

// Instantiate DB & connect
$database = new Connect();
$db = $database->connect();

// Instantiate User object
$User = new User($db);

// Get ID
$User->id_client = isset($_GET['id_client']) ? $_GET['id_client'] : die();

// User query
$result = $User->getInfo();
// Get row count
$num = $result->rowCount();

// Check if any User
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
