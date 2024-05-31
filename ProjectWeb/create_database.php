<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS fkpark";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db("fkpark");

// Function to create table with foreign key constraint checks
function createTable($conn, $tableName, $createQuery) {
    $sql = "SHOW TABLES LIKE '$tableName'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        if ($conn->query($createQuery) === TRUE) {
            echo "Table '$tableName' created successfully\n";
        } else {
            echo "Error creating table '$tableName': " . $conn->error . "\n";
        }
    } else {
        echo "Table '$tableName' already exists\n";
    }
}

// Create users table
createTable($conn, 'users', "CREATE TABLE users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    UserFullname VARCHAR(255) NOT NULL,
    UserCategory VARCHAR(50) NOT NULL,  // 'admin', 'staff', 'student'
    UserGender VARCHAR(10) NOT NULL,
    Username VARCHAR(255) UNIQUE NOT NULL,
    UserPassword VARCHAR(255) NOT NULL,
    UserContact VARCHAR(20) NOT NULL
)");

// Create user_registrations table
createTable($conn, 'user_registrations', "CREATE TABLE user_registrations (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending'
)");

// Create Vehicles table
createTable($conn, 'Vehicles', "CREATE TABLE Vehicles (
    VehicleID INT AUTO_INCREMENT PRIMARY KEY,
    VehicleType VARCHAR(20) NOT NULL,
    VehiclePlate VARCHAR(10) NOT NULL,
    VehicleGrant BLOB,
    VehicleColor VARCHAR(20),
    VehicleModel VARCHAR(20),
    UserID INT,
    FOREIGN KEY (UserID) REFERENCES users(UserID) ON DELETE CASCADE ON UPDATE CASCADE
)");

// Create VehicleStickers table
createTable($conn, 'VehicleStickers', "CREATE TABLE VehicleStickers (
    VehicleStickerID INT AUTO_INCREMENT PRIMARY KEY,
    StickerType VARCHAR(20) NOT NULL,
    ExpiryDate DATE,
    UserID INT,
    VehicleID INT,
    FOREIGN KEY (UserID) REFERENCES users(UserID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (VehicleID) REFERENCES Vehicles(VehicleID) ON DELETE CASCADE ON UPDATE CASCADE
)");

// Create QRCode table
createTable($conn, 'QRCode', "CREATE TABLE QRCode (
    QRCodeID INT AUTO_INCREMENT PRIMARY KEY,
    QRCodeImage BLOB,
    QRCodeInfo VARCHAR(100),
    VehicleStickerID INT,
    UserID INT,
    FOREIGN KEY (VehicleStickerID) REFERENCES VehicleStickers(VehicleStickerID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (UserID) REFERENCES users(UserID) ON DELETE CASCADE ON UPDATE CASCADE
)");

// Create RegistrationVehicle table
createTable($conn, 'RegistrationVehicle', "CREATE TABLE RegistrationVehicle (
    RegistrationVehicleID INT AUTO_INCREMENT PRIMARY KEY,
    Status BOOLEAN,
    Date DATE,
    UserID INT,
    FOREIGN KEY (UserID) REFERENCES users(UserID) ON DELETE CASCADE ON UPDATE CASCADE
)");

// Create ParkingSpace table
createTable($conn, 'ParkingSpace', "CREATE TABLE ParkingSpace (
    ParkingSpaceID INT AUTO_INCREMENT PRIMARY KEY,
    NumberOfSpace INT NOT NULL,
    Status BOOLEAN,
    UserID INT,
    FOREIGN KEY (UserID) REFERENCES users(UserID) ON DELETE CASCADE ON UPDATE CASCADE
)");

// Create Booking table
createTable($conn, 'Booking', "CREATE TABLE Booking (
    BookingID INT AUTO_INCREMENT PRIMARY KEY,
    BookingDateTime DATETIME,
    ExpectedParkingDuration INT,
    Status BOOLEAN,
    UserID INT,
    VehicleID INT,
    ParkingSpaceID INT,
    FOREIGN KEY (UserID) REFERENCES users(UserID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (VehicleID) REFERENCES Vehicles(VehicleID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ParkingSpaceID) REFERENCES ParkingSpace(ParkingSpaceID) ON DELETE CASCADE ON UPDATE CASCADE
)");

// Create TrafficSummon table
createTable($conn, 'TrafficSummon', "CREATE TABLE TrafficSummon (
    SummonID INT AUTO_INCREMENT PRIMARY KEY,
    Status BOOLEAN,
    SummonDate DATETIME,
    SummonInformation VARCHAR(100),
    ViolationType VARCHAR(30),
    DemeritPoints INT,
    UserID INT,
    KeselamatanID INT,
    FOREIGN KEY (UserID) REFERENCES users(UserID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (KeselamatanID) REFERENCES users(UserID) ON DELETE CASCADE ON UPDATE CASCADE
)");

$conn->close();
?>

