<?php
$servername = "192.168.64.200";
$username = "root";
$password_db = "root";
$dbname = "TpGPS";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

$sql = "SELECT latitude, longitude, date FROM trame";
$result = $conn->query($sql);

$locations = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = array("latitude" => $row["latitude"], "longitude" => $row["longitude"], "date" => $row["date"]);
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($locations);
?>
