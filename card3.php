<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP SYSTÈME RFID</title>
    <link rel="stylesheet" href="card.min.css">
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;,">
</head>

<body>
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
                    <img src="#" alt="no-picture" id="stu-photo">
                </div>
                <div class="stu-info">
                    <h3>Étudiant n° : <span id="uid"></span></h3>
                    <p>Nom : <span id="nom"></span></p>
                    <p>Prénom : <span id="prenom"></span></p>
                    <p>Né le : <span id="naissance"></span></p>
                    <p><span id="regime"></span><span style="padding-left: 150px;" id="classe"></span></p>
                </div>
            </div>
            <div class="clear"></div><footer>
			<p><strong>Lycée Professionnel la Providence Amiens </strong> <p>
			<p>146 bd Saint-Quentin, 80094 AMIENS cedex 3</p>
			<p>Tel: 03 22 33 77 77 | E-mail: contact@la-providence.net</p>
			<p>Copryrights © Tout droits réservés avec © www.la-providence.net</p>
      </footer>
    </div>
      
      
		</div>
	</div>

    <script>
        var socket = new WebSocket("ws://192.168.64.129:12345");

        socket.onopen = function (event) {
            console.log("WebSocket connection opened.");
        };

        socket.onmessage = function (event) {
            // Mettez à jour les informations du badge RFID avec les données JSON reçues du WebSocket
            var jsonData = JSON.parse(event.data);
            console.log("Received JSON data:", jsonData);

            // Mettez à jour les informations du badge avec les données JSON
            var photoUrl = jsonData.uid ? "http://192.168.65.237/TP3-HUGO/TP3/new/photo/" + jsonData.uid + ".jpg" : "";
            console.log("Photo URL:", photoUrl);
            document.getElementById('stu-photo').src = photoUrl;

            document.getElementById('uid').innerText = jsonData.uid;
            document.getElementById('nom').innerText = jsonData.nom;
            document.getElementById('prenom').innerText = jsonData.prenom;
            document.getElementById('naissance').innerText = jsonData.naissance;
            document.getElementById('regime').innerText = jsonData.regime;
            document.getElementById('classe').innerText = jsonData.classe;
        };

        // Le reste du code WebSocket et XMLHttpRequest reste inchangé
    </script>

</body>

</html>
