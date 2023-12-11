<?php
session_start();

function Modification_user() {
    // Vérifiez si l'utilisateur est connecté
    if (!isset($_SESSION['userId'])) {
        header("Location: connexion.php"); // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
        exit();
    }

    // Définissez des variables pour stocker les valeurs actuelles
    $currentLogname = $_SESSION['logname'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifier_info"])) {
        // Récupérez les nouvelles données du formulaire
        $newLogname = $_POST["newLogname"];
        $newLogpass = $_POST["newLogpass"];

        // Connexion à la base de données
        $servername = "192.168.64.200";
        $username = "root";
        $password_db = "root";
        $dbname = "TpGPS";

        $conn = new mysqli($servername, $username, $password_db, $dbname);

        // Vérifiez la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $user_id = $_SESSION['userId'];

        // Requête SQL pour mettre à jour les informations de connexion de l'utilisateur
        $sql = "UPDATE user SET logname='$newLogname', logpass='$newLogpass' WHERE id = $user_id";

        if ($conn->query($sql) === TRUE) {
            // Mettez à jour les valeurs actuelles
            $currentLogname = $newLogname;
            $_SESSION['logname'] = $newLogname;

            echo "Vos informations de connexion ont été mises à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour des informations de connexion : " . $conn->error;
        }

        // Fermer la connexion à la base de données
        $conn->close();
    }
}

// Appeler la fonction de modification
Modification_user();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier les informations de connexion</title>
</head>
<body>
    <h2>Modifier les informations de connexion</h2>
    <form method="post" action="modification.php">
        <label for="newLogname">Nouveau nom d'utilisateur :</label>
        <input type="text" name="newLogname" value="<?php echo $currentLogname; ?>" required><br><br>

        <label for="newLogpass">Nouveau mot de passe :</label>
        <input type="password" name="newLogpass" required><br><br>

        <input type="submit" name="modifier_info" value="Modifier">
    </form>

    <br>
    <a href="acceuil.php">Retour à la page d'accueil</a>
</body>
</html>
