<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userId"]) && isset($_POST["field"]) && isset($_POST["value"])) {
    // Récupérez les données de la requête POST
    $userId = $_POST["userId"];
    $field = $_POST["field"];
    $value = $_POST["value"];

    // Connexion à la base de données
    $servername = "192.168.65.252";
    $username = "root";
    $password_db = "root";
    $dbname = "TpGPS";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Vérifiez la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Échappez les valeurs pour éviter les injections SQL (utilisez des requêtes préparées pour une sécurité maximale)
    $userId = $conn->real_escape_string($userId);
    $field = $conn->real_escape_string($field);
    $value = $conn->real_escape_string($value);

    // Requête SQL pour mettre à jour les informations de l'utilisateur
    $sql = "UPDATE user SET $field='$value' WHERE id = $userId";

    if ($conn->query($sql) === TRUE) {
        echo "success"; // Réponse AJAX indiquant que la mise à jour a réussi
    } else {
        echo "error"; // Réponse AJAX indiquant une erreur lors de la mise à jour
    }

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    echo "Requête invalide."; // Réponse AJAX en cas de requête invalide
}
?>
