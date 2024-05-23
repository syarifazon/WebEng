<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - FKPark</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>FKPark</h1>
        <nav>
            <a href="user_register.php">Register</a>
            <a href="login.php">Login</a>
        </nav>
    </header>
    <div class="container">
        <h2>Register</h2>
        <form method="post" action="user_register.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required><br>
            
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select><br><br>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            
            <input type="submit" value="Register">
        </form>
    </div>
    <footer>
        <p>&copy; 2024 FKPark</p>
    </footer>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "fkpark";

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape and retrieve form data
    $userFullname = $conn->real_escape_string($_POST['name']);
    $userCategory = "student"; // Assuming all users registering through this form are students
    $userGender = $conn->real_escape_string($_POST['gender']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']); // Assuming password is directly entered by the user
    $userContact = $conn->real_escape_string($_POST['phone']);

    // Insert user registration data into the database
    $sql = "INSERT INTO user_registrations (name, email, phone, gender, username, password) 
            VALUES ('$userFullname', '', '$userContact', '$userGender', '$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        $message = "User registration request submitted successfully. Waiting for admin approval.";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>





