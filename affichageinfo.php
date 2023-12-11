<?php
session_start(); // Assurez-vous que la session est démarrée

// Vérifiez si l'utilisateur est connecté
if(isset($_SESSION['userId'])) {
    $user_id = $_SESSION['userId'];

    // Connexion à la base de données
    $servername = "192.168.64.200";
    $username = "root";
    $password_db = "root";
    $dbname = "TpGPS";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Requête SQL pour vérifier si l'utilisateur est un administrateur
    $sql = "SELECT * FROM user WHERE id = $user_id AND IsAdmin = 1";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // L'utilisateur est un administrateur, affichez les données de la table `user`
        $sql = "SELECT * FROM user";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Afficher les données dans un tableau HTML avec des styles CSS
            echo "<style>
                    table {
                        font-family: Arial, sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                    }
                    th, td {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                    tr:nth-child(even) {
                        background-color: #f2f2f2;
                    }
                  </style>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Nom d'utilisateur</th><th>Mot de passe</th><th>Email</th><th>Admin</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"] . "</td><td>" . $row["logname"] . "</td><td>" . $row["logpass"] . "</td><td>" . $row["logemail"] . "</td><td>" . $row["IsAdmin"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "Aucune donnée trouvée dans la table `user`.";
        }
    } else {
        echo "Accès non autorisé. Vous devez être administrateur pour voir cette page.";
    }

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    echo "Accès non autorisé. Vous devez être connecté pour voir cette page.";
}
?>
