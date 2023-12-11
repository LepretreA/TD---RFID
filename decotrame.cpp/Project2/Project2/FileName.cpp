#include <iostream>
#include <sstream>
#include <string>
#include <vector>

struct GPGGAData {
    std::string time;
    double latitude;
    char latDirection;
    double longitude;
    char lonDirection;
    int fixQuality;
    int numSatellites;
    double horizontalAccuracy;
    double altitude;
    char altitudeUnit;
    double geoidSeparation;
    char geoidUnit;
    std::string checksum;
};

bool parseGPGGA(const std::string& sentence, GPGGAData& data) {
    // Vérifiez si la trame commence par "$GPGGA".
    if (sentence.compare(0, 7, "$GPGGA,") != 0) {
        return false;
    }

    std::istringstream ss(sentence);
    char comma;  // stocke les virgule

    ss >> data.time;
    ss >> comma;
    ss >> data.latitude;
    ss >> comma;
    ss >> data.latDirection;
    ss >> data.longitude;
    ss >> comma;
    ss >> data.lonDirection;
    ss >> data.fixQuality;
    ss >> data.numSatellites;
    ss >> data.horizontalAccuracy;
    ss >> comma;
    ss >> data.altitude;
    ss >> comma;
    ss >> data.altitudeUnit;
    ss >> data.geoidSeparation;
    ss >> comma;
    ss >> data.geoidUnit;
    ss >> comma;
    ss >> data.checksum;

    return true;
}

int main() {
    std::string nmeaSentence = "$GPGGA,123519,4807.038,N,01131.000,E,1,08,0.9,545.4,M,46.9,M,,*47";
    GPGGAData gpgga;

    if (parseGPGGA(nmeaSentence, gpgga)) {
        std::cout << "Time: " << gpgga.time << std::endl;
        std::cout << "Latitude: " << gpgga.latitude << " " << gpgga.latDirection << std::endl;
        std::cout << "Longitude: " << gpgga.longitude << " " << gpgga.lonDirection << std::endl;
        std::cout << "Fix Quality: " << gpgga.fixQuality << std::endl;
        std::cout << "Number of Satellites: " << gpgga.numSatellites << std::endl;
        std::cout << "Horizontal Accuracy: " << gpgga.horizontalAccuracy << " meters" << std::endl;
        std::cout << "Altitude: " << gpgga.altitude << " " << gpgga.altitudeUnit << std::endl;
        std::cout << "Geoid Separation: " << gpgga.geoidSeparation << " " << gpgga.geoidUnit << std::endl;
    }
    else {
        std::cerr << "Invalid NMEA sentence." << std::endl;
    }

    return 0;
}
