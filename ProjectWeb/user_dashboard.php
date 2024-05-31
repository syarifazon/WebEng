<?php
session_start();
if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    die();
}
include 'connection.php';

// Fetch user data
$userID = $_SESSION['user_id'];
$sql_user = "SELECT * FROM users WHERE UserID = ?";
$stmt = $conn->prepare($sql_user);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result_user = $stmt->get_result();
$user_data = $result_user->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>User Dashboard</h1>
        <nav>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="content-user-dashboard">
        <h2>Welcome, <?php echo $user_data['UserFullname']; ?></h2>
        <div class="dashboard">
            <div class="stat_table">
                <h3>User Information</h3>
                <table>
                    <tr>
                        <th>User ID</th>
                        <td><?php echo $user_data['UserID']; ?></td>
                    </tr>
                    <tr>
                        <th>Full Name</th>
                        <td><?php echo $user_data['UserFullname']; ?></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td><?php echo $user_data['UserCategory']; ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?php echo $user_data['UserGender']; ?></td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td><?php echo $user_data['Username']; ?></td>
                    </tr>
                    <tr>
                        <th>Contact</th>
                        <td><?php echo $user_data['UserContact']; ?></td>
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
</body>
</html>
