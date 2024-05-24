<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register User - FKPark</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image: url('user_register.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            color: #000;
            font-family: Arial, sans-serif;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: transparent; /* Make navbar background transparent */
            padding: 10px;
        }
        .navbar h1 {
            color: #000;
            background-color: transparent; /* Make title background transparent */
        }
        .nav-links {
            display: flex;
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .nav-links a {
            color: #000;
            background-color: transparent;
            text-decoration: none;
            padding: 5px;
            display: flex;
            align-items: center;
            margin-left: 10px;
        }
        .nav-links a:hover {
            background-color: #ddd;
        }
        .sidebar {
            display: none; /* Hide the sidebar for the new layout */
        }
        .content {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            margin: 20px;
            border-radius: 8px;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
        }
        .content table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            border-radius: 8px;
            margin: 20px;
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <h1>FKPark Admin</h1>
            <div class="nav-links">
                <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="admin_register.php"><i class="fas fa-user-plus"></i> Register User</a>
                <a href="#"><i class="fas fa-users-cog"></i> Manage User</a>
                <a href="#"><i class="fas fa-car"></i> Manage Vehicle</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </header>
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

        // Process form submission first
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['registration_id'])) {
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
        }

        // Fetch pending registrations
        $sql = "SELECT * FROM user_registrations WHERE status='pending'";
        $result = $conn->query($sql);

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

        $conn->close();
        ?>
    </div>
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>
</body>
</html>




