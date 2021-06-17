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
}
