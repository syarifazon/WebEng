<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: login.php");
    exit();
}
require_once('connection.php');

$user_info = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get search criteria
    $userID = $_POST['userID'];
    $username = $_POST['username'];

    // Check if search criteria is provided
    if (!empty($userID) || !empty($username)) {
        // Construct SQL query based on provided search criteria
        $sql = "SELECT * FROM users WHERE UserID = ? OR Username = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $userID, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user is found
        if ($result->num_rows > 0) {
            // Display user information and delete button
            $user_info .= "<h2>User Information</h2>";
            while ($row = $result->fetch_assoc()) {
                $user_info .= "<div>";
                $user_info .= "<p>User ID: " . $row['UserID'] . "</p>";
                $user_info .= "<p>Username: " . $row['Username'] . "</p>";
                $user_info .= "<p>Full Name: " . $row['UserFullname'] . "</p>";
                $user_info .= "<p>Contact: " . $row['UserContact'] . "</p>";
                // Add more user information fields as needed
                $user_info .= "<form action='admin_manage_user.php' method='post'>";
                $user_info .= "<input type='hidden' name='delete_user_id' value='" . $row['UserID'] . "'>";
                $user_info .= "<input type='submit' name='delete_user' value='Delete'>";
                $user_info .= "</form>";
                $user_info .= "</div>";
            }
        } else {
            $user_info = "<p>No user found with the provided criteria.</p>";
        }
    } else {
        $user_info = "<p>Please provide user ID or username to search.</p>";
    }
}

// Handle delete request
if (isset($_POST['delete_user'])) {
    $delete_user_id = $_POST['delete_user_id'];
    // Perform deletion from the database
    $sql_delete = "DELETE FROM users WHERE UserID = ?";
    $stmt_delete = $con->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_user_id);
    $stmt_delete->execute();
    if ($stmt_delete->affected_rows > 0) {
        $user_info .= "<p>User with ID: $delete_user_id has been deleted.</p>";
    } else {
        $user_info .= "<p>Error deleting user.</p>";
    }
}

$sql_all_users = "SELECT UserID, Username FROM users";
$result_all_users = $con->query($sql_all_users);
$all_users_info = "";

// Check if there are users
if ($result_all_users->num_rows > 0) {
    // Display all user IDs with their usernames
    $all_users_info .= "<h2>All Users</h2>";
    while ($row = $result_all_users->fetch_assoc()) {
        $all_users_info .= "<p>User ID: " . $row['UserID'] . ", Username: " . $row['Username'] . "</p>";
    }
} else {
    $all_users_info = "<p>No users found.</p>";
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User - Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .chart-container {
            display: flex;
            justify-content: space-between;
        }
        .chart {
            width: 40%;
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
        .navbar i {
            margin-right: 5px;
        }
        .events-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .events-table th, .events-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .events-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
    <div class="navbar">
        <h1>Manage User - FKPark</h1>
        <div class="nav-links">
            <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="admin_register.php"><i class="fas fa-user-plus"></i> Register User</a>
            <a href="admin_manage_user.php"><i class="fas fa-users-cog"></i> Manage User</a>
            <a href="manage_vehicle.php"><i class="fas fa-car"></i> Manage Vehicle</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    </header>
    <div class="content-userprofile">
        <!-- Search form -->
        <div class="search-form">
            <h2>Search User</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="userID">User ID:</label>
                <input type="text" name="userID" id="userID">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username">
                <input type="submit" value="Search">
            </form>
        </div>
        <!-- User information and delete button -->
        <div class="all-users-container">
            <?php echo $all_users_info; ?>
        </div>
        <?php echo $user_info; ?>
    </div>
    <!-- Footer section -->
</body>
</html>
