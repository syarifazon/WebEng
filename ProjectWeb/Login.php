<?php
session_start();
require_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Please fill in all fields";
    } else {
        $username = $con->real_escape_string($_POST['username']);
        $password = $con->real_escape_string($_POST['password']);
        $role = $con->real_escape_string($_POST['role']);

        $sql = "SELECT * FROM users WHERE Username = '$username' AND UserCategory = '$role' AND UserPassword = '$password'";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            if ($role === 'Administrator') {
                header("Location: admin_dashboard.php");
            } elseif ($role === 'Student') {
                header("Location: student_dashboard.php");
            } elseif ($role === 'Keselamatan Staff') {
                header("Location: staff_dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid username, role, or password";
        }
    }
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
                <option value="Administrator">Administrator</option>
                <option value="Student">Student</option>
                <option value="Keselamatan Staff">Keselamatan Staff</option>
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
