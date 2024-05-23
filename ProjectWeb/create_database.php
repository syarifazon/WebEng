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

// Check if users table exists
$sql = "SHOW TABLES LIKE 'users'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Create users table
    $sql = "CREATE TABLE users (
        UserID INT AUTO_INCREMENT PRIMARY KEY,
        UserFullname VARCHAR(255) NOT NULL,
        UserCategory VARCHAR(50) NOT NULL,
        UserGender VARCHAR(10) NOT NULL,
        Username VARCHAR(255) UNIQUE NOT NULL,
        UserPassword VARCHAR(255) NOT NULL,
        UserContact VARCHAR(20) NOT NULL
    )";
    if ($conn->query($sql) === TRUE) {
        echo "Table 'users' created successfully\n";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} else {
    echo "Table 'users' already exists\n";
}

// Check if user_registrations table exists
$sql = "SHOW TABLES LIKE 'user_registrations'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Create user_registrations table
    $sql = "CREATE TABLE user_registrations (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        gender VARCHAR(10) NOT NULL,
        username VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        status VARCHAR(20) DEFAULT 'pending'
    )";
    if ($conn->query($sql) === TRUE) {
        echo "Table 'user_registrations' created successfully\n";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} else {
    echo "Table 'user_registrations' already exists\n";
}

$conn->close();
?>
