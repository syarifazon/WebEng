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
        <h1>FKPark Admin </h1>
    </header>
    <div class="sidebar">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_register.php">Register User</a>
        <a href="#">Manage User</a>
        <a href="#">Manage Vehicle</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <h2>Pending User Registrations</h2>
        <?php
        $db_host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "fkpark";

        $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch pending registrations
        $sql = "SELECT * FROM user_registrations WHERE status='pending'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Name</th><th>Email</th><th>Phone Number</th><th>Gender</th><th>Username</th><th>Actions</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["gender"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>
                        <form method='post' action='admin_register.php'>
                            <input type='hidden' name='registration_id' value='" . $row["id"] . "'>
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $registration_id = $_POST['registration_id'];

            if (isset($_POST['approve'])) {
                // Approve the registration
                $sql = "SELECT * FROM user_registrations WHERE id='$registration_id'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    // Generate UserID
                    $userID = uniqid('user_'); // Example: Generates a unique ID with a prefix

                    // Insert user data into the users table
                    $sql_insert = "INSERT INTO users (UserID, UserFullname, UserCategory, UserGender, Username, UserPassword, UserContact) 
                                   VALUES ('$userID', '" . $row['name'] . "', 'student', '" . $row['gender'] . "', '" . $row['username'] . "', '" . $row['password'] . "', '" . $row['phone'] . "')";
                    if ($conn->query($sql_insert) === TRUE) {
                        // Update the status of the registration request
                        $sql_update = "UPDATE user_registrations SET status='approved' WHERE id='$registration_id'";
                        $conn->query($sql_update);
                        echo "<p>User approved and registered successfully.</p>";
                    } else {
                        echo "Error: " . $sql_insert . "<br>" . $conn->error;
                    }
                }
            } elseif (isset($_POST['reject'])) {
                // Reject the registration
                $sql_update = "UPDATE user_registrations SET status='rejected' WHERE id='$registration_id'";
                if ($conn->query($sql_update) === TRUE) {
                    echo "<p>User registration rejected.</p>";
                } else {
                    echo "Error: " . $sql_update . "<br>" . $conn->error;
                }
            }
        }

        $conn->close();
        ?>
    </div>
    <footer>
        <p>&copy; 2024 FKPark</p>
    </footer>
</body>
</html>


