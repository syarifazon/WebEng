<?php
require_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $con->real_escape_string($_POST['name']);
    $email = $con->real_escape_string($_POST['email']);
    $phone = $con->real_escape_string($_POST['phone']);
    $gender = $con->real_escape_string($_POST['gender']);
    $username = $con->real_escape_string($_POST['username']);
    $password = $con->real_escape_string($_POST['password']);
    $status = 'pending'; // Registration status is pending by default

    $sql = "INSERT INTO user_registrations (name, email, phone, gender, username, password, status) 
            VALUES ('$name', '$email', '$phone', '$gender', '$username', '$password', '$status')";
    
    if ($con->query($sql) === TRUE) {
        echo "<script type='text/javascript'>alert('Registration submitted successfully. Waiting for admin approval.');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}
?>

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
        <nav class="navigation">
            <a href="user_register.php">Register</a>
            <a>&#10072;</a>
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
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select><br><br>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            
            <input type="submit" value="Register">
        </form>
    </div>
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>
</body>
</html>








