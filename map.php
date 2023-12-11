<!DOCTYPE html>
<html>

<head>
    <title>TP Mise en route</title>
    <!-- Inclure des liens vers les bibliothèques Leaflet CSS et JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>

<body>
    <?php
    // Connexion à la base de données
    $servername = "192.168.64.200";
    $username = "root";
    $password_db = "root";
    $dbname = "TpGPS";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Vérifiez la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    // Récupérez les coordonnées GPS depuis la base de données
    $sql = "SELECT latitude, longitude, date FROM trame ORDER BY date DESC LIMIT 10";
    $result = $conn->query($sql);

    $locations = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $locations[] = array("latitude" => $row["latitude"], "longitude" => $row["longitude"], "date" => $row["date"]);
        }
    }

    $conn->close();
    ?>


    <div id="map" style="width: 1650px; height: 600px;"></div>

    <script>
        var map;
        var markers = [];
        var polyline;

        function initializeMap() {
            map = L.map('map').setView([46.3622, 1.5231], 6);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
        }

        function updateMapWithData() {
            $.ajax({
                url: 'fetch_data.php', // L'URL du script PHP qui récupère les nouvelles données
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Effacez les anciens marqueurs
                    markers.forEach(function(marker) {
                        map.removeLayer(marker);
                    });
                    markers = [];

                    // Par défaut, utilisez l'icône normale
                    var defaultIcon = L.icon({
                        iconUrl: 'https://upload.wikimedia.org/wikipedia/commons/0/0e/Basic_red_dot.png',
                        iconSize: [7, 7],
                    });

                    // Définissez l'icône spéciale pour le dernier marqueur
                    var lastMarkerIcon = L.icon({
                        iconUrl: 'https://upload.wikimedia.org/wikipedia/commons/4/41/Red_circle.gif',
                        iconSize: [20, 20],
                    });

                    // Ajoutez les nouveaux marqueurs
                    data.forEach(function(location, index) {
                        var icon = (index === data.length - 1) ? lastMarkerIcon : defaultIcon;

                        // Calculez la distance entre le point actuel et le point précédent
                        var distanceToPrevious = (index > 0) ? calculateDistance(data[index - 1], location) : 0;

                        var marker = L.marker([location.latitude, location.longitude], {
                                icon: icon
                            })
                            .bindPopup('Coordonnées GPS : ' + location.latitude + ', ' + location.longitude + '<br>Distance au point précédent :<span style="color:red"> ' + distanceToPrevious.toFixed(2) + ' km</span>')
                            .on('mouseover', function(e) {
                                this.openPopup();
                            })
                            .on('mouseout', function(e) {
                                this.closePopup();
                            })
                            .addTo(map);

                        markers.push(marker);
                    });

                    // Créez la polyline en utilisant les coordonnées des marqueurs
                    if (polyline) {
                        map.removeLayer(polyline);
                    }

                    // Supprimez le dernier marqueur du tableau
                    var polylineMarkers = markers.slice(0, markers.length - 1);

                    polyline = L.polyline(polylineMarkers.map(function(marker) {
                        return marker.getLatLng();
                    }), {
                        color: 'red'
                    }).addTo(map);



                },
                error: function(xhr, status, error) {
                    console.log('Erreur lors de la récupération des données : ' + error);
                }
            });
        }

        function calculateDistance(point1, point2) {
            // La fonction prend deux objets avec des propriétés latitude et longitude
            var R = 6371; // Rayon de la Terre en kilomètres
            var dLat = deg2rad(point2.latitude - point1.latitude);
            var dLon = deg2rad(point2.longitude - point1.longitude);
            var a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(point1.latitude)) * Math.cos(deg2rad(point2.latitude)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var distance = R * c; // Distance en kilomètres
            return distance;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }


        $(document).ready(function() {
            initializeMap();
            updateMapWithData(); // Appelez cette fonction une fois au chargement de la page

            // Actualisez les données de la carte toutes les 3 secondes
            setInterval(updateMapWithData, 1000);
        });
    </script>


</body>

</html>