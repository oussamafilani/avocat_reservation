<?php

class User
{
    // DB stuff
    private $conn;
    private $tables = ['user', 'client', 'creneaux', 'appointment'];

    // user Properties
    public $id_user;
    public $token;

    // client Properties
    public $id_client;
    public $nom_client;
    public $prenom_client;
    public $profession;
    public $age_client;
    public $cin;

    // creneaux Properties
    public $id_creneaux;
    public $d_hour;
    public $f_hour;

    // appointment Properties
    public $id_appointment;
    public $date;
    public $sujet;



    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }



    // Get appointment
    public function read()
    {
        // Create query
        $query = 'SELECT * FROM ' . $this->tables[1] . '';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get appointment
    public function getInfo()
    {
        // Create query
        // private $tables = ['user', 'client', 'creneaux', 'appointment'];
        $query = "SELECT * FROM ((" . $this->tables[3] . "
        INNER JOIN " . $this->tables[1] . " on client.id_client = appointment.id_client)
        INNER JOIN " . $this->tables[2] . " on creneaux.id_creneaux = appointment.id_creneaux)
        WHERE client.id_client = ?";


        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id_client);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    public function CheckCin()
    {
        $stmt  = $this->conn->prepare("SELECT * FROM "  . $this->tables[1] . " WHERE cin = :cin");
        $stmt->bindValue(':cin', $this->cin, PDO::PARAM_STR);
        $stmt->execute();
        $RowCount = $stmt->rowCount();
        return  $RowCount;
    }

    public function CheckToken()
    {
        $stmt  = $this->conn->prepare("SELECT * FROM"  . $this->tables[0] . "WHERE token = :token");
        $stmt->bindValue(':token', $this->token, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashPassword = $row['token'];
        $RowCount = $stmt->rowCount();


        if ($RowCount  == 1 && !empty($row) && password_verify($this->token, $hashPassword)) {
            // Initialize the session
            // session_start();
            // $_SESSION['token'] =  $row['id_user'];
            return  true;
        } else {
            return false;
        }
    }


    public function Register()
    {
        $stmt  = $this->conn->prepare("INSERT INTO "  . $this->tables[0] . " (token) VALUES (:token)");
        $stmt->bindValue(':token',  $this->token, PDO::PARAM_STR);
        $stmt->execute();

        $stmt1  = $this->conn->prepare("SELECT * FROM user WHERE token = :token");
        $stmt1->bindValue(':token',  $this->token, PDO::PARAM_STR);
        $stmt1->execute();
        $row = $stmt1->fetch(PDO::FETCH_ASSOC);
        $this->id_user = $row['id_user'];



        $stmt2  = $this->conn->prepare("INSERT INTO "  . $this->tables[1] . " (nom_client, prenom_client, profession,age_client,id_user,cin) VALUES (:nom_client, :prenom_client, :profession, :age_client,:id_user,:cin)");

        $stmt2->bindValue(':nom_client',  $this->nom_client, PDO::PARAM_STR);
        $stmt2->bindValue(':prenom_client',  $this->prenom_client, PDO::PARAM_STR);
        $stmt2->bindValue(':profession',  $this->profession, PDO::PARAM_STR);
        $stmt2->bindValue(':age_client',  $this->age_client, PDO::PARAM_INT);
        $stmt2->bindValue(':id_user',  $this->id_user, PDO::PARAM_INT);
        $stmt2->bindValue(':cin',  $this->cin, PDO::PARAM_STR);

        // Execute query
        if ($stmt2->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }
}
