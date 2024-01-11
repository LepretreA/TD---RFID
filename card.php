<?php
    session_start();
    include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card</title>
    <link rel="stylesheet" href="card.min.css">
</head>
<body>
<?php

    // Requête SQL pour sélectionner tous les éléments de la table 'utilisateurs'
    $query = "SELECT * FROM utilisateurs ORDER BY uid DESC LIMIT 1";
    //$query = "SELECT * FROM utilisateurs WHERE id='1'";
    $result = mysqli_query($conn, $query);

    // Vérifier si la requête s'est bien déroulée
    if ($result) {
        // Afficher les résultats dans le style que vous avez fourni
        while ($row = mysqli_fetch_assoc($result)) {
            $_utilisateurs_uid = $row['uid'];
            $_utilisateurs_nom = $row['nom'];
            $_utilisateurs_prenom = $row['prenom'];
            $_utilisateurs_classe = $row['classe'];
            $_utilisateurs_regime = $row['regime'];
            $_utilisateurs_photo = $row['photo'];
            $_utilisateurs_naissance = $row['naissance'];
            // ... continuez avec d'autres champs selon votre structure de table
        ?>
	<div class="id-card-holder">
		<div class="id-card">
			<div class="header">
				<img src="https://file.diplomeo-static.com/file/00/00/01/46/14675.svg">
                <p class="id">Carte scolaire 2023-2024</p>
        <div class="clear"></div>
      </div>
      <span class="b-border"></span>
      
        <div class="card-detail">
            <div class="stu-photo">
            <img src="http://192.168.65.237/TP3-HUGO/TP3/new/photo/<?php echo $_utilisateurs_uid; ?>.jpg" alt="no-picture" >
        </div>
        <div class="stu-info">
          <h3>Étudiant n° : <span> <?php echo $_utilisateurs_uid; ?></span></h3>
          <p>Nom : <span> <?php echo $_utilisateurs_nom; ?></span></p>
          <p>Prénom :<span> <?php echo $_utilisateurs_prenom; ?></span></p>
          <p>Né le : <span> <?php echo $_utilisateurs_naissance; ?></span></p>
          <p><span><?php echo $_utilisateurs_regime; ?></span><span style="padding-left: 150px;" ><?php echo $_utilisateurs_classe; ?></span></p>
        </div>
        <?php
        }
    } else {
        echo "Erreur dans la requête : " . mysqli_error($conn);
    }

    // Fermer la connexion
    mysqli_close($conn);
?>
        
        <div class="clear"></div>
    </div>
      
      <footer>
			<p><strong>Lycée Professionnel la Providence Amiens </strong> <p>
			<p>146 bd Saint-Quentin, 80094 AMIENS cedex 3</p>
			<p>Tel: 03 22 33 77 77 | E-mail: contact@la-providence.net</p>
			<p>Copryrights © Tout droits réservés avec © www.la-providence.net</p>
      </footer>
		</div>
	</div>

    <script>
    var socket = new WebSocket("ws://192.168.65.25:8081");

    socket.onopen = function(event) {
        console.log("WebSocket connection opened.");
    };

    socket.onmessage = function(event) {
        // Mettez à jour les informations du badge RFID avec les données de la base de données
        var badgeInfo = JSON.parse(event.data);

        // Utilisez les données extraites de la base de données pour mettre à jour le DOM
        document.getElementById('uid').innerText = badgeInfo.uid;
        document.getElementById('nom').innerText = badgeInfo.nom;
        document.getElementById('prenom').innerText = badgeInfo.prenom;
        document.getElementById('classe').innerText = badgeInfo.classe; // Ajoutez d'autres mises à jour selon votre structure
        document.getElementById('regime').innerText = badgeInfo.regime;
        // ... Ajoutez d'autres mises à jour d'éléments selon votre structure
    };
</script>




</body>
</html>