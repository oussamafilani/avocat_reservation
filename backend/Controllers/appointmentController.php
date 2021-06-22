<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

class appointmentController
{

    // Appointment Properties
    private $database;
    private $db;
    private $Appointment;
    private $chekToken;

    // Get raw posted data


    public function __construct()
    {
        // Instantiate DB & connect
        $this->database = new Connect();
        $this->db = $this->database->connect();
        // Instantiate Appointment object
        $this->Appointment = new Appointment($this->db);
        $this->data  = json_decode(file_get_contents("php://input"));
    }

    // public function checkTimes()
    // {
    // }
    public function availableTimes()
    {
        $this->Appointment->date = $this->data->date;
        // available times query
        $result = $this->Appointment->availableTimes();
        // Get row count
        $num = $result->rowCount();

        // Check if any available times
        if ($num > 0) {
            // Post array
            $posts_arr = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $post_item = array(
                    'd_hour' => $d_hour,
                );

                // Push to "data"
                array_push($posts_arr, $post_item);
            }

            // Turn to JSON & output
            echo json_encode($posts_arr);
        } else {
            echo json_encode(
                array('message' => 'theres no times')
            );
        }
    }

    public function createAppointment()
    {

        //Check  token
        $this->Appointment->token = $this->data->token;
        $this->chekToken = $this->Appointment->CheckToken();

        $this->Appointment->date = $this->data->date;
        $this->Appointment->sujet = $this->data->sujet;
        $this->Appointment->id_creneaux = $this->data->id_creneaux;
        $this->Appointment->id_client = $this->data->id_client;

        // Create Appointment
        if ($this->chekToken) {
            if ($this->Appointment->create()) {
                echo json_encode(
                    array('message' => 'Appointment Created')
                );
            } else {
                echo json_encode(
                    array('message' => 'Appointment Not Created')
                );
            }
        } else {
            echo json_encode(
                array('message' => 'Token Not Valid')
            );
        }
    }

    public function deleteAppointment()
    {
        //check  token
        $this->Appointment->token = $this->data->token;
        $this->chekToken = $this->Appointment->CheckToken();

        // Set ID to delete

        $this->Appointment->id_appointment = $this->data->id_appointment;

        // Delete Appointment
        if ($this->chekToken) {
            if ($this->Appointment->delete()) {
                echo json_encode(
                    array('message' => 'Appointment Deleted')
                );
            } else {
                echo json_encode(
                    array('message' => 'Appointment Not Deleted')
                );
            }
        } else {
            echo json_encode(
                array('message' => 'Token Not Valid')
            );
        }
    }

    public function getClientAppointment()
    {

        //check  token
        $this->Appointment->token = $this->data->token;
        $this->chekToken = $this->Appointment->CheckToken();

        $this->Appointment->id_client = $this->Appointment->getIdClientFromToken();


        if ($this->chekToken) {
            // Appointment query
            $result = $this->Appointment->getClientAppointment();
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
        } else {
            echo json_encode(
                array('message' => 'Token Not Valid')
            );
        }
    }

    public function readAppointment()
    {
        // Appointment query
        $result = $this->Appointment->read();
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
    }

    public function updateAppointment()
    {

        //check  token
        $this->Appointment->token = $this->data->token;
        $chekToken = $this->Appointment->CheckToken();


        // Set ID to update
        $this->Appointment->id_appointment = $this->data->id_appointment;

        // $Appointment->token = $data->token;
        $this->Appointment->date = $this->data->date;
        $this->Appointment->sujet = $this->data->sujet;
        $this->Appointment->id_creneaux = $this->data->id_creneaux;

        // Update post
        if ($chekToken) {
            if ($this->Appointment->update()) {
                echo json_encode(
                    array('message' => 'Appointment Updated')
                );
            } else {
                echo json_encode(
                    array('message' => 'Appointment Not Updated')
                );
            }
        } else {
            echo json_encode(
                array('message' => 'Token No Valid')
            );
        }
    }
}
