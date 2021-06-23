<?php
class Appointment
{
    // DB stuff
    private $conn;
    private $table = 'appointment';

    // Appointment Properties
    public $id_appointment;
    public $sujet;
    public $id_creneaux;
    public $id_client;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function checkTimes()
    {
        $stmt  = $this->conn->prepare('SELECT * FROM ' . $this->table . ' WHERE date = :date and id_creneaux:id_creneaux');
        $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
        $stmt->bindValue(':id_creneaux', $this->id_creneaux, PDO::PARAM_INT);
        $stmt->execute();
        $RowCount = $stmt->rowCount();
        return  $RowCount;
    }
    public function availableTimes()
    {

        $stmt  = $this->conn->prepare(" SELECT creneaux.d_hour FROM creneaux WHERE id_creneaux NOT IN (SELECT id_creneaux FROM appointment where date = :date)");
        $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
        $stmt->execute();
        return  $stmt;
    }

    //Get Id client from token
    public function getIdClientFromToken()
    {
        // Prepare statement
        $stmt  = $this->conn->prepare("SELECT client.id_client FROM client INNER JOIN user on client.id_user = user.id_user AND user.token =:token");
        $stmt->bindValue(':token', $this->token, PDO::PARAM_STR);
        // Execute query
        $stmt->execute();
        $num = $stmt->rowCount();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($num > 0) {

            return $row['id_client'];
        } else {
            return false;
        }
    }

    // Get appointment
    public function read()
    {
        // Create query
        $query = 'SELECT * FROM ' . $this->table . '';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }


    public function CheckToken()
    {
        $stmt  = $this->conn->prepare("SELECT * FROM user WHERE token = :token");
        $stmt->bindValue(':token', $this->token, PDO::PARAM_STR);
        $stmt->execute();
        // $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // return $row['token'];
        $RowCount = $stmt->rowCount();
        return $RowCount;


        // if ($RowCount  == 1 && !empty($row) && password_verify($this->token, $hashPassword)) {
        //     return  true;
        // } else {
        //     return false;
        // }
    }

    // Get Single Appointment
    public function getClientAppointment()
    {
        // Create query
        $query = 'SELECT * FROM ' . $this->table . '  WHERE appointment.id_client = ?';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id_client);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Create Appointment
    public function create()
    {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' SET date = :date, sujet = :sujet, id_creneaux = :id_creneaux, id_client = :id_client';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->sujet = htmlspecialchars(strip_tags($this->sujet));
        $this->id_creneaux = htmlspecialchars(strip_tags($this->id_creneaux));
        $this->id_client = htmlspecialchars(strip_tags($this->id_client));

        // Bind data
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':sujet', $this->sujet);
        $stmt->bindParam(':id_creneaux', $this->id_creneaux);
        $stmt->bindParam(':id_client', $this->id_client);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }
    }

    // Update Appointment
    public function update()
    {


        // Create query
        $query = 'UPDATE ' . $this->table . '
                                  SET date = :date, sujet = :sujet, id_creneaux = :id_creneaux
                                  WHERE id_appointment = :id_appointment';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->sujet = htmlspecialchars(strip_tags($this->sujet));
        $this->id_creneaux = htmlspecialchars(strip_tags($this->id_creneaux));
        $this->id = htmlspecialchars(strip_tags($this->id_appointment));

        // Bind data
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':sujet', $this->sujet);
        $stmt->bindParam(':id_creneaux', $this->id_creneaux);
        $stmt->bindParam(':id_appointment', $this->id_appointment);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return true;
    }


    // Delete Appointment
    public function delete()
    {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id_appointment = :id_appointment';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id_appointment = htmlspecialchars(strip_tags($this->id_appointment));

        // Bind data
        $stmt->bindParam(':id_appointment', $this->id_appointment);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
