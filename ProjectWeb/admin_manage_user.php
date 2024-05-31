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
            // Fetch and display user information
            $row = $result->fetch_assoc();
            $user_info .= "<h2>User Information</h2>";
            $user_info .= "<p>User ID: " . $row['UserID'] . "</p>";
            $user_info .= "<p>Username: " . $row['Username'] . "</p>";
            $user_info .= "<p>Full Name: " . $row['UserFullname'] . "</p>";
            $user_info .= "<p>Contact: " . $row['UserContact'] . "</p>";
            // Add more user information fields as needed
        } else {
            $user_info = "<p>No user found with the provided criteria.</p>";
        }
    } else {
        $user_info = "<p>Please provide user ID or username to search.</p>";
    }
}
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
        <?php echo $user_info; ?>
    </div>
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>
</body>
</html>
