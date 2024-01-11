<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Scanner</title>
    <style>
        /* Ajoutez votre propre style CSS ici si nécessaire */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        #rfidData {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>RFID Scanner</h1>
    <div id="rfidData"></div>

    <script>
        const socket = new WebSocket('ws://192.168.64.129:12345');
        const rfidDataElement = document.getElementById('rfidData');

        socket.onmessage = (event) => {
            const data = event.data;
            // Ajoutez le code nécessaire pour mettre en forme et afficher les données
            const newParagraph = document.createElement('p');
            newParagraph.textContent = data;
            rfidDataElement.appendChild(newParagraph);
        };
    </script>
</body>
</html>
