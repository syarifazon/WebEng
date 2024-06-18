<?php
require_once('connection.php');

// Function to insert a user if not exists
function insertUser($fullname, $category, $gender, $username, $password, $contact, $con) {
    // Check if the user already exists
    $sql = "SELECT * FROM users WHERE Username = '$username'";
    $result = $con->query($sql);

    if ($result->num_rows == 0) {
        // Insert the user
        $sql = "INSERT INTO users (UserFullname, UserCategory, UserGender, Username, UserPassword, UserContact) 
                VALUES ('$fullname', '$category', '$gender', '$username', '$password', '$contact')";
        
        if ($con->query($sql) === TRUE) {
            echo "$fullname ($category) created successfully\n";
        } else {
            echo "Error creating $fullname: " . $con->error . "\n";
        }
    } else {
        echo "$fullname ($category) already exists\n";
    }
}

// Insert admin user
insertUser('Muhamad Syarifudin', 'Administrator', 'Male', 'admin', 'admin_123', '0197552553', $con);

// Insert Keselamatan Staff user
insertUser('Haikal', 'Keselamatan Staff', 'Male', 'staff', 'staff_password', '0189068595', $con);


$con->close();
?>

