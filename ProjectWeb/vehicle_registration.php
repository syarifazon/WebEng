<?php 
include('connection.php');
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Registration - FKPark</title>
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
            <h1>Vehicle Registration - FKPark</h1>
            <div class="nav-links">
                <a href="user_dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                <a href="user_profile.php"><i class="fas fa-user"></i>User Profile</a>
                <a href="vehicle_registration.php"><i class="fas fa-car"></i>Vehicle Registration</a>
                <a href="manage_vehicle.php"><i class="fas fa-car"></i>Manage Vehicle</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </div>
        </div>
    </header>
    <div class="vehicleReg-content">
    <div class="vehicleReg-form">
        <h2>Vehicle Registration Form</h2>
        <?php
        $currentUser = $_SESSION['username']; 
        $findUser = "SELECT UserID, UserFullName FROM users WHERE Username = '$currentUser' ";
        $run = mysqli_query($con, $findUser);

        $userinfo = mysqli_fetch_array($run);

        ?>
        <form action="vehicle_registration_process.php" method="post" enctype="multipart/form-data">
            <label for="userID">User ID:</label>
            <input type="text" id="userID" name="userID" readonly value="<?php echo $userinfo['UserID'] ?>">

            <label for="userFullName">User Full Name:</label>
            <input type="text" id="userFullName" name="userFullName" readonly value="<?php echo $userinfo['UserFullName'] ?>">

            <label for="vehiclePlate">Vehicle Plate Number:</label>
            <input type="text" id="vehiclePlate" name="vehiclePlate" required>

            <label for="vehicleModel">Vehicle Model:</label>
            <input type="text" id="vehicleModel" name="vehicleModel" required>

            <label for="vehicleType">Vehicle Type:</label>
            <select id="vehicleType" name="vehicleType" required>
                <option value="Car">Car</option>
                <option value="Motorcycle">Motorcycle</option>
            </select>

            <label for="vehicleColor">Vehicle Color:</label>
            <input type="text" id="vehicleColor" name="vehicleColor" required>

            <label for="grantUpload">Upload Grant:</label>
            <input type="file" id="file" name="file" accept=".pdf" required>

            <br><input type="submit" name="submit" value="Register">
        </form>
    </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>
</body>
</html>
