<?php
// database.php

$host = "192.168.64.200";
$username = "root";
$password = "root";
$dbname = "RFID";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM utilisateurs WHERE uid = ?";
$stmt = mysqli_prepare($conn, $query);

// Liaison de paramètres
mysqli_stmt_bind_param($stmt, "s", $_GET['query']);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    $response = array("error" => "Query failed: " . mysqli_error($conn));
    echo json_encode($response);
} else {
    $row = $result->fetch_assoc();
    if ($row) {
        echo json_encode($row);
    } else {
        echo json_encode(array("error" => "No results found."));
    }
}


mysqli_close($conn);
?>
