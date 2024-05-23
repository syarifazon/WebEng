<?php
require_once('connection.php');

// Check if the admin user already exists
$sql = "SELECT * FROM users WHERE Username = 'admin'";
$result = $con->query($sql);

if ($result->num_rows == 0) {
    // Insert initial admin user
    $adminPassword = "admin_password"; // Change "admin_password" to your desired password
    $sql = "INSERT INTO users (UserFullname, UserCategory, UserGender, Username, UserPassword, UserContact) 
            VALUES ('Admin', 'Administrator', 'Other', 'admin', '$adminPassword', '0000000000')";
    
    if ($con->query($sql) === TRUE) {
        echo "Admin user created successfully\n";
    } else {
        echo "Error creating admin user: " . $con->error;
    }
} else {
    echo "Admin user already exists\n";
}

$con->close();
?>