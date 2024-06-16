<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Student') {
    header("location: login.php");
    die();
}
require_once('connection.php');

// Fetch user data
$userID = $_SESSION['user_id'];
$sql_user = "SELECT * FROM users WHERE UserID = ?";
$stmt = $con->prepare($sql_user);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result_user = $stmt->get_result();
$user_data = $result_user->fetch_assoc();

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
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
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <h1>User Dashboard - FKPark</h1>
            <div class="nav-links">
                <a href="user_dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                <a href="user_parking_view.php"><i class="fas fa-tachometer-alt"></i>Parking</a>
                <a href="user_profile.php"><i class="fas fa-user"></i>User Profile</a>
                <a href="vehicle_registration.php"><i class="fas fa-car"></i>Vehicle Registration</a>
                <a href="user_manage_vehicle.php"><i class="fas fa-car"></i>Manage Vehicle</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </div>
        </div>
    </header>
    <div class="content-user-dashboard">
        
        <div class="dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($user_data['UserFullname']); ?></h2>
            <div class="stat_table">
                <h3>User Information</h3>
                <table>
                    <tr>
                        <th>User ID</th>
                        <td><?php echo htmlspecialchars($user_data['UserID']); ?></td>
                    </tr>
                    <tr>
                        <th>Full Name</th>
                        <td><?php echo htmlspecialchars($user_data['UserFullname']); ?></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td><?php echo htmlspecialchars($user_data['UserCategory']); ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?php echo htmlspecialchars($user_data['UserGender']); ?></td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td><?php echo htmlspecialchars($user_data['Username']); ?></td>
                    </tr>
                    <tr>
                        <th>Contact</th>
                        <td><?php echo htmlspecialchars($user_data['UserContact']); ?></td>
                    </tr>
                </table>
            </div>
            <!-- Placeholder for future user functionalities -->
            <div class="user_functions">
                <h3>Your Functions</h3>
                <p>Here you can add user-specific functionalities like booking, viewing summons, etc.</p>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>
</body>
</html>

