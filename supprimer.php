<!DOCTYPE html>
<html>
<head>
    <title>Suppression de compte</title>
</head>
<body>

<h2>Suppression de compte</h2>

<form method="post" action="">
    <label for="login">Nom d'utilisateur:</label>
    <input type="text" id="login" name="login" required><br><br>

    <label for="passwd">Mot de passe:</label>
    <input type="password" id="passwd" name="passwd" required><br><br>

    <input type="submit" name="submit" value="Supprimer le compte">
</form>

<?php

if (isset($_POST['submit'])) {

    $login = $_POST['login'];
    $passwd = $_POST['passwd'];


    Suppression_user($login, $passwd);
}


function Suppression_user($login, $passwd) {
   
    $host = "192.168.65.252";        
    $user = "root"; 
    $password = "root"; 
    $database = "TpGPS";  
    
    $conn = new mysqli($host, $user, $password, $database);

   
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    
    $login = $conn->real_escape_string($login);
    $passwd = $conn->real_escape_string($passwd);


    $checkUserQuery = "SELECT * FROM `user` WHERE `logname` = '$login' AND `logpass` = '$passwd'";
    

    $result = $conn->query($checkUserQuery);

    if ($result->num_rows === 1) {
       
        $deleteQuery = "DELETE FROM `user` WHERE `logname` = '$login' AND `logpass` = '$passwd'";
        
        if ($conn->query($deleteQuery) === TRUE) {
            ?>
            <script type="text/javascript">
     
            setTimeout(function() {
                window.location.href = 'index.php'; 
            }, 30);
        </script>
        <?php
        } else {
            echo "Erreur lors de la suppression de votre compte : " . $conn->error;
        }
    } else {
        echo "Erreur : nom d'utilisateur ou mot de passe incorrect.";
    }


    $conn->close();
}
?>

</body>
</html>


