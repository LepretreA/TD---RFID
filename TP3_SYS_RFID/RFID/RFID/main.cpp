#include <QCoreApplication>
#include <QSerialPort>
#include <QSerialPortInfo>
#include <QWebSocketServer>
#include <QWebSocket>
#include <QTimer>

class ArduinoReader : public QObject
{
	Q_OBJECT

public:
	ArduinoReader(QObject *parent = nullptr) : QObject(parent)
	{
		serial = new QSerialPort(this);
		server = new QWebSocketServer("WebSocket Server", QWebSocketServer::NonSecureMode, this);

		// Remplacez "COM3" par le port série de votre Arduino
		serial->setPortName("COM3");
		serial->setBaudRate(QSerialPort::Baud9600);

		connect(serial, SIGNAL(readyRead()), this, SLOT(readData()));
		connect(server, &QWebSocketServer::newConnection, this, &ArduinoReader::onNewConnection);

		qDebug() << "\n$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$\n";

		if (serial->open(QIODevice::ReadOnly)) {
			qDebug() << "SERIAL_PORT_OPENED_ON_COM3.";

			if (server->listen(QHostAddress::Any, 12345)) { // Choisissez le port que vous préférez
				qDebug() << "WEBSOCKET_SERVER_OPENED_ON" << server->serverPort() <<".";
			}
			else {
				qDebug() << "FAILED_TO_OPEN_WEBSOCKET_SERVER.";
			}
		}
		else {
			qDebug() << "FAILED_TO_OPEN_SERIAL_PORT.";
		}

		qDebug() << "\n$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$\n";

		// Timer pour envoyer les données au client toutes les 100 millisecondes
		connect(&sendTimer, &QTimer::timeout, this, &ArduinoReader::sendToClients);
		sendTimer.start(100);
	}

public slots:
	void readData()
	{
		QByteArray data = serial->readAll();
		// Assurez-vous que les données lues sont valides avant de les traiter
		if (!data.isEmpty()) {
			buffer.append(data);

			while (buffer.contains("\r\n")) {
				int endIndex = buffer.indexOf("\r\n") + 2; // Ajoutez 2 pour inclure les caractères de fin de ligne
				QByteArray uidData = buffer.left(endIndex);
				buffer = buffer.mid(endIndex);

				QString uid = QString(uidData).remove(QRegExp("[^A-Fa-f0-9]"));

				if (!uid.isEmpty()) {
					qDebug() << uid;

					// Envoyer l'UID aux clients WebSocket connectés
					foreach(QWebSocket *client, clients) {
						client->sendTextMessage(uid);
					}
				}
			}
		}
	}


	void sendToClients()
	{
		while (buffer.size() >= 3) {  // Taille minimale d'un UID dans cet exemple
			QByteArray uidData = buffer.left(3);
			buffer = buffer.mid(3);

			QString uid = QString(uidData).remove(QRegExp("[^A-Fa-f0-9]"));
			qDebug() << uid;

			// Envoyer l'UID aux clients WebSocket connectés
			foreach(QWebSocket *client, clients) {
				client->sendTextMessage(uid);
			}
		}
	}

	void onNewConnection()
	{
		QWebSocket *clientSocket = server->nextPendingConnection();
		connect(clientSocket, &QWebSocket::disconnected, this, &ArduinoReader::onSocketDisconnected);
		clients << clientSocket;
		qDebug() << "Nouvelle connexion WebSocket.";
	}

	void onSocketDisconnected()
	{
		QWebSocket *clientSocket = qobject_cast<QWebSocket *>(sender());
		if (clientSocket) {
			clients.removeOne(clientSocket);
			clientSocket->deleteLater();
			qDebug() << "Connexion WebSocket fermée.";
		}
	}

private:
	QSerialPort *serial;
	QWebSocketServer *server;
	QList<QWebSocket *> clients;
	QTimer sendTimer;
	QByteArray buffer;
};

int main(int argc, char *argv[])
{
	QCoreApplication a(argc, argv);

	ArduinoReader arduinoReader;

	return a.exec();
}

#include "main.moc"
