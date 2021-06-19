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
