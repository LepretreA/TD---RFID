#include <QCoreApplication>
#include <QSerialPort>
#include <QSerialPortInfo>
#include <QDebug>
#include <QWebSocketServer>
#include <QWebSocket>
#include <QObject>
#include <QList>

int main(int argc, char* argv[])
{
    QCoreApplication a(argc, argv);

    // Configuration du port série
    QSerialPort serialPort;
    serialPort.setPortName("COM4"); // Remplacez "COMx" par le port de votre Arduino
    serialPort.setBaudRate(QSerialPort::Baud9600); // Assurez-vous que la vitesse correspond à celle de votre Arduino

    // Ouverture du port série
    if (!serialPort.open(QIODevice::ReadOnly)) {
        qDebug() << "Failed to open serial port";
        return 1;
    }

    QWebSocketServer server(QStringLiteral("WebSocket Server"), QWebSocketServer::NonSecureMode);

    if (!server.listen(QHostAddress::Any, 12345)) {
        qCritical() << "Failed to start WebSocket server:" << server.errorString();
        return 1;
    }

    qDebug() << "WebSocket server listening on port" << server.serverPort();

    // Liste pour stocker les sockets des clients WebSocket
    QList<QWebSocket*> clients;

    // Fonction de rappel appelée lorsqu'une nouvelle connexion WebSocket est établie
    QObject::connect(&server, &QWebSocketServer::newConnection, [&]() {
        // Récupérez le socket WebSocket pour cette connexion
        QWebSocket* webSocket = server.nextPendingConnection();

        // Ajoutez le nouveau client à la liste
        clients.append(webSocket);
        
        // Fonction de rappel appelée lorsqu'une nouvelle donnée est reçue du client WebSocket
        QObject::connect(webSocket, &QWebSocket::textMessageReceived, [&](const QString& message) {
            qDebug() << "Received data from WebSocket:" << message;
            // Ajoutez ici votre logique pour traiter les données WebSocket comme vous le souhaitez
            });

        // Fonction de rappel appelée lorsqu'un client WebSocket est déconnecté
        QObject::connect(webSocket, &QWebSocket::disconnected, [&]() {
            qDebug() << "WebSocket client disconnected";
            // Supprimez le client déconnecté de la liste
            clients.removeOne(webSocket);
            webSocket->deleteLater(); // Libérez les ressources lorsque le client est déconnecté
            });
        });

    // Lecture et affichage des données en continu du port série
    QByteArray receivedData;  // Variable pour stocker les données reçues

    while (true) {
        if (serialPort.waitForReadyRead(100)) {
            receivedData.append(serialPort.readAll());

            // Vérifiez s'il y a un caractère de fin (par exemple, '\n') pour afficher les données sur une seule ligne
            if (receivedData.contains('\n')) {
                // Retirez le caractère de fin et les caractères de retour chariot
                receivedData = receivedData.replace("\n", "").replace("\r", "");

                // Supprimez tous les espaces
                receivedData.replace(" ", "");

                qDebug() << "Received data from Serial Port:" << receivedData;

                // Envoyez les données à tous les clients WebSocket connectés
                for (QWebSocket* client : clients) {
                    client->sendTextMessage(receivedData);
                }

                // Réinitialisez la variable pour la prochaine ligne de données
                receivedData.clear();
            }
        }
    }

    // Retournez 0 à la fin de la fonction main
    return 0;
}
