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
    private $chekTime;

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
                    'd_hour' => $d_hour . '-' . $f_hour,
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

        switch ($this->data->id_creneaux) {
            case '10:00:00-10:30:00':
                $this->Appointment->id_creneaux = 1;
                break;
            case '11:00:00-11:30:00':
                $this->Appointment->id_creneaux = 2;
                break;
            case '14:00:00-14:30:00':
                $this->Appointment->id_creneaux = 3;
                break;
            case '15:00:00-15:30:00':
                $this->Appointment->id_creneaux = 4;
                break;
            case '16:00:00-16:30:00':
                $this->Appointment->id_creneaux = 5;
                break;
        }

        $this->Appointment->id_client =  $this->Appointment->getIdClientFromToken();

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

                    switch ($id_creneaux) {
                        case 1:
                            $id_creneaux = '10:00:00-10:30:00';
                            break;
                        case 2:
                            $id_creneaux = '11:00:00-11:30:00';
                            break;
                        case 3:
                            $id_creneaux = '14:00:00-14:30:00';
                            break;
                        case 4:
                            $id_creneaux = '15:00:00-15:30:00';
                            break;
                        case 5:
                            $id_creneaux = '16:00:00-16:30:00';
                            break;
                    }

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
        switch ($this->data->id_creneaux) {
            case '10:00:00-10:30:00':
                $this->Appointment->id_creneaux = 1;
                break;
            case '11:00:00-11:30:00':
                $this->Appointment->id_creneaux = 2;
                break;
            case '14:00:00-14:30:00':
                $this->Appointment->id_creneaux = 3;
                break;
            case '15:00:00-15:30:00':
                $this->Appointment->id_creneaux = 4;
                break;
            case '16:00:00-16:30:00':
                $this->Appointment->id_creneaux = 5;
                break;
        }

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
