#include <QCoreApplication>
#include <QSerialPort>
#include <QSerialPortInfo>
#include <QDebug>
#include <QTimer>

class ArduinoReader : public QObject
{
	Q_OBJECT

public:
	ArduinoReader(QObject *parent = nullptr) : QObject(parent)
	{
		serial = new QSerialPort(this);

		// Remplacez "COM3" par le port série de votre Arduino
		serial->setPortName("COM3");
		serial->setBaudRate(QSerialPort::Baud9600);

		connect(serial, SIGNAL(readyRead()), this, SLOT(readData()));
		connect(&timer, SIGNAL(timeout()), this, SLOT(handleTimeout()));

		if (serial->open(QIODevice::ReadOnly)) {
			qDebug() << "Port serie ouvert avec succes.";
			timer.start(100); // Ajustez selon les besoins
		}
		else {
			qDebug() << "Impossible d'ouvrir port serie.";
		}
	}

public slots:
	void readData()
	{
		buffer.append(serial->readAll());
	}

	void handleTimeout()
	{
		if (!buffer.isEmpty()) {
			QString uid = QString(buffer).remove(QRegExp("[^A-Fa-f0-9]"));
			if (!uid.isEmpty()) {
				qDebug() << "UID du badge RFID : " << uid;
			}
			buffer.clear();
		}
	}

private:
	QSerialPort *serial;
	QTimer timer;
	QByteArray buffer;
};

int main(int argc, char *argv[])
{
	QCoreApplication a(argc, argv);

	ArduinoReader arduinoReader;

	return a.exec();
}

#include "main.moc"
