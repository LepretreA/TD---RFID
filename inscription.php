<?php
session_start();


class InscriptionManager {
    private $conn;

    public function __construct() {
        // Remplacez les données de connexion à votre base de données
        $servername = "192.168.64.200";
        $username = "root";
        $password_db = "root";
        $dbname = "TpGPS";

        // Établissez la connexion à la base de données
        $this->conn = new mysqli($servername, $username, $password_db, $dbname);

        // Vérifiez la connexion
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function createUser($name, $email, $password) {
        // Requête SQL pour insérer un nouvel utilisateur
        $sql = "INSERT INTO user (logname, logemail, logpass , isAdmin) VALUES ('$name', '$email', '$password', '0')";
        if ($this->conn->query($sql) === TRUE) {
            header("Location: acceuil.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function closeConnection() {
        // Fermez la connexion à la base de données
        $this->conn->close();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["inscription"])) {
    // Récupérez les données du formulaire
    $name = $_POST["logname"];
    $email = $_POST["logemail"];
    $password = $_POST["logpass"];

    $inscriptionManager = new InscriptionManager();
    $inscriptionManager->createUser($name, $email, $password);
    $inscriptionManager->closeConnection();
}
?>
