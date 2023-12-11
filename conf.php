<?php
session_start();
$servername = "192.168.64.200"; // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = "root"; // Mot de passe MySQL
$database = "TpGPS"; // Nom de la base de données

// Créez une connexion à la base de données
$connection = mysqli_connect($servername, $username, $password, $database);

// Vérifiez la connexion
if (!$connection) {
    die("Échec de la connexion à la base de données : " . mysqli_connect_error());
}
?>
