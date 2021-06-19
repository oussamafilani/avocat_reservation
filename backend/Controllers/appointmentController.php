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
}
