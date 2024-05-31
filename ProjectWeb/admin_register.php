<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: login.php");
    exit();
}
require_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registration_id'])) {
    $registration_id = $_POST['registration_id'];

    if (isset($_POST['approve'])) {
        // Approve the registration
        $sql = "SELECT * FROM user_registrations WHERE id='$registration_id'";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Insert user data into the users table
            $sql_insert = "INSERT INTO users (UserFullname, UserCategory, UserGender, Username, UserPassword, UserContact) 
                           VALUES ('" . $row['name'] . "', 'Student', '" . $row['gender'] . "', '" . $row['username'] . "', '" . $row['password'] . "', '" . $row['phone'] . "')";
            if ($con->query($sql_insert) === TRUE) {
                // Update the status of the registration request
                $sql_update = "UPDATE user_registrations SET status='approved' WHERE id='$registration_id'";
                $con->query($sql_update);
                echo "<p>User approved and registered successfully.</p>";
            } else {
                echo "Error: " . $sql_insert . "<br>" . $con->error;
            }
        }
    } elseif (isset($_POST['reject'])) {
        // Reject the registration
        $sql_update = "UPDATE user_registrations SET status='rejected' WHERE id='$registration_id'";
        if ($con->query($sql_update) === TRUE) {
            echo "<p>User registration rejected.</p>";
        } else {
            echo "Error: " . $sql_update . "<br>" . $con->error;
        }
    }
}

$sql = "SELECT * FROM user_registrations WHERE status='pending'";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register User - FKPark</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>FKPark Admin</h1>
        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin_register.php">Register User</a>
            <a href="manage_user.php">Manage User</a>
            <a href="manage_vehicle.php">Manage Vehicle</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="content">
        <h2>Pending User Registrations</h2>
        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Name</th><th>Email</th><th>Phone Number</th><th>Gender</th><th>Username</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["gender"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>
                        <form method='post' action='admin_register.php'>
                            <input type='hidden' name='registration_id' value='" . $row["ID"] . "'>
                            <input type='submit' name='approve' value='Approve'>
                            <input type='submit' name='reject' value='Reject'>
                        </form>
                      </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No pending registrations.</p>";
        }

        $con->close();
        ?>
    </div>
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>
</body>
</html>





