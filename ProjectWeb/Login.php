<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "fkpark";

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $role = $conn->real_escape_string($_POST['role']);

    $sql = "SELECT * FROM users WHERE Username = '$username' AND UserCategory = '$role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['UserPassword'])) {
            // Password and role match, proceed with login
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Redirect based on user role
            if ($role === 'Administrator') {
                header("Location: admin_dashboard.php");
            } else {
                // Redirect to a default page for other user roles
                header("Location: default_dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "No user found with the given username and role";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FKPark</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>FKPark</h1>
        <nav class=navigation>
            <a href="user_register.php">Register</a>
            <a>&#10072;</a>
            <a href="login.php">Login</a>
        </nav>
    </header>
    <div class="container">
    <h2>Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            
            <label for="role">User Type:</label>
            <select id="role" name="role" required>
                <option value="admin">Administrator</option>
                <option value="student">Student</option>
                <option value="staff">Keselamatan Staff</option>
            </select><br><br>
            
            <input type="submit" value="Login">
        </form>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>
</body>
</html>
