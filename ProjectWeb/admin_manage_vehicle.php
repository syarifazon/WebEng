<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: login.php");
    exit();
}
require_once('connection.php');

$vehicle_info = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get search criteria
    $vehicleid = isset($_POST['vehicleID']) ? $_POST['vehicleID'] : "";
    $vehiclePlate = isset($_POST['vehiclePlate']) ? $_POST['vehiclePlate'] : "";

    // Check if search criteria is provided
    if (!empty($vehicleid) || !empty($vehiclePlate)) {
        // Construct SQL query based on provided search criteria
        // $sql = "SELECT * FROM vehicles WHERE VehicleID = ? OR VehiclePlate = ?";
        $sql = "SELECT u.*, v.*, vs.*, qr.*
                FROM users u
                JOIN vehicles v ON u.UserID = v.UserID
                JOIN vehiclestickers vs ON v.VehicleID = vs.VehicleID
                JOIN qrcode qr ON vs.VehicleStickerID = qr.VehicleStickerID
                WHERE v.VehicleID = ? OR v.VehiclePlate = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $vehicleid, $vehiclePlate);
        $stmt->execute();
        $result = $stmt->get_result();

        // $findQr = "SELECT qr.QRCodeImage, ";

        // Check if user is found
        if ($result->num_rows > 0) {
            // Display user information and delete button
            $vehicle_info .= "<h2>Vehicle Information</h2>";
            while ($row = $result->fetch_assoc()) {
                $vehicle_info .= "<div>";
                $vehicle_info .= "<p>Full Name: " . $row['UserFullname'] . "</p>";
                $vehicle_info .= "<p>Contact: " . $row['UserContact'] . "</p>";
                $vehicle_info .= "<p>Vehicle Plate: " . $row['VehiclePlate'] . "</p>";
                $vehicle_info .= "<img src= ' " . $row['QRCodeImage'] . " '>";
                // Add more user information fields as needed
                $vehicle_info .= "<form action='admin_manage_vehicle.php' method='post'>";
                $vehicle_info .= "<input type='hidden' name='delete_vehicle_id' value='" . $row['VehicleID'] . "'>";
                $vehicle_info .= "<input type='submit' name='delete_vehicle' value='Delete'>";
                $vehicle_info .= "</form>";
                $vehicle_info .= "</div>";
            }
        } else {
            $vehicle_info = "<p>No vehicle found with the provided criteria.</p>";
        }
    } else {
        $vehicle_info = "<p>Please provide vehicle ID or vehicle plate number to search.</p>";
    }
}

// Handle delete request
if (isset($_POST['delete_user'])) {
    $delete_vehicle_id = $_POST['delete_vehicle_id'];
    // Perform deletion from the database
    $sql_delete = "DELETE FROM vehicles WHERE VehicleID = ?";
    $stmt_delete = $con->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_vehicle_id);
    $stmt_delete->execute();
    if ($stmt_delete->affected_rows > 0) {
        $vehicle_info .= "<p>Vehicle with ID : $delete_vehicle_id has been deleted.</p>";
    } else {
        $vehicle_info .= "<p>Error deleting vehicle.</p>";
    }
}

$sql_all_vehicle = "SELECT VehicleID, VehiclePlate FROM vehicles";
$result_all_vehicle = $con->query($sql_all_vehicle);
$all_vehicle_info = "";

// Check if there are users
if ($result_all_vehicle->num_rows > 0) {
    // Display all vehicle IDs with their plate number
    $all_vehicle_info .= "<h2>All Vehicles</h2>";
    while ($row = $result_all_vehicle->fetch_assoc()) {
        $all_vehicle_info .= "<p>Vehicle ID: " . $row['VehicleID'] . ", Plate Number: " . $row['VehiclePlate'] . "</p>";
    }
} else {
    $all_vehicle_info = "<p>No vehicles found.</p>";
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Vehicle - Admin Panel</title>
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

        .vehicle-list {
            display: flex;
        }
    </style>
</head>
<body>
    <!-- <header>
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
    </header> -->
    <header>
            <h1>Manage Vehicle - FKPark</h1>
    </header>
    
            <!-- <div class="sidebar">
                <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="admin_register.php"><i class="fas fa-user-plus"></i> Register User</a>
                <a href="admin_manage_user.php"><i class="fas fa-users-cog"></i> Manage User</a>
                <a href="manage_vehicle.php"><i class="fas fa-car"></i> Manage Vehicle</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div> -->

    <div class="sidebar">
        <hr>
        <a href="admin_dashboard.php">Dashboard</a>
        <hr>
        <a href="admin_register.php">Register User</a>
        <hr>
        <a href="admin_manage_user.php">Manage User</a>
        <hr>
        <a href="admin_manage_vehicle.php">Manage Vehicle</a>
        <hr>
        <a href="logout.php">Logout</a>
        <hr>
    </div>

    <div class="content-vehicle">
        <div class="vehicle-list">
            <div class="search-form">
                <h2>Search Vehicle</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <label for="vehicleID">Vehicle ID:</label>
                    <input type="text" name="vehicleID" id="vehicleID">
                    <label for="vehiclePlate">Plate Number:</label>
                    <input type="text" name="vehiclePlate" id="vehiclePlate">
                    <input type="submit" name="search" value="Search">
                </form>
            </div>
            <div class="all-vehicle-container">
                
                <?php echo $all_vehicle_info; ?>
            </div>
        </div>
        <div class="vehicle-info">
            <?php echo $vehicle_info; ?>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>
</body>
</html>
