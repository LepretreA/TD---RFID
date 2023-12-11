<?php
session_start();



class ConnexionManager {
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

    public function Autorisation($email, $password) {
        // Requête SQL pour vérifier l'utilisateur
        $sql = "SELECT * FROM user WHERE logemail='$email' AND logpass='$password'";
        $result = $this->conn->query($sql);

        // Si l'utilisateur est trouvé, redirigez-le vers acceuil.php et stockez son ID dans une variable de session
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION["userId"] = $row["id"]; // Stockez l'ID dans une variable de session
            $_SESSION["logname"] = $row["logname"];
            header("Location: acceuil.php");
            exit();
        } else {
            echo "mail ou mot de passe incorrect.";
        }
    }

    public function closeConnection() {
        // Fermez la connexion à la base de données
        $this->conn->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["connexion"])) {
    // Récupérez les données du formulaire
    $email = $_POST["logemail"];
    $password = $_POST["logpass"];

    $connexionManager = new ConnexionManager();
    $connexionManager->Autorisation($email, $password);
    $connexionManager->closeConnection();
}
?>
