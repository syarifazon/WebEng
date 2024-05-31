<?php
session_start();
require_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['role'])) {
        $error = "Please fill in all fields";
    } else {
        $username = $con->real_escape_string($_POST['username']);
        $password = $con->real_escape_string($_POST['password']);
        $role = $con->real_escape_string($_POST['role']);

        if ($role === 'Student') {
            // Check for students with approved status from user_registrations table
            $sql = "SELECT * FROM users WHERE Username = ? AND UserPassword = ?";
        } else {
            // Check for admin and Keselamatan Staff from users table
            $sql = "SELECT * FROM users WHERE Username = ? AND UserCategory = ? AND UserPassword = ?";
        }

        $stmt = $con->prepare($sql);
        if ($role === 'Student') {
            $stmt->bind_param("ss", $username, $password);
        } else {
            $stmt->bind_param("sss", $username, $role, $password);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify credentials and set session variables
        if ($user) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            if ($role === 'Student') {
                $_SESSION['user_id'] = $user['UserID']; // Assuming 'UserID' is the primary key in users
                header("Location: user_dashboard.php");
            } elseif ($role === 'Administrator') {
                $_SESSION['user_id'] = $user['UserID']; // Assuming 'UserID' is the primary key in users
                header("Location: admin_dashboard.php");
            } elseif ($role === 'Keselamatan Staff') {
                $_SESSION['user_id'] = $user['UserID']; // Assuming 'UserID' is the primary key in users
                header("Location: staff_dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid username, role, or password";
        }

        $stmt->close();
    }
    $con->close();
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
        <nav class="navigation">
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
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>
</body>
</html>






