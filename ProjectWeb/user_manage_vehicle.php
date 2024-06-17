<?php 
include('connection.php');
session_start();
$currentUser = $_SESSION['username'];
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
        .content-user-dashboard {
            flex: 0;
            padding: 20px;
        }
    </style>
</head>
<body>
    <header>
        <!-- <div class="navbar"> -->
            <h1>Vehicle Approval - FKPark</h1>
            <!-- <div class="nav-links">
                <a href="staff_dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                <a href="staff_manage_vehicle.php"><i class="fas fa-car"></i>Manage Vehicle</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </div>
        </div> -->
    </header>
    <div class="sidebar">
        <hr>
        <a href="user_dashboard.php">Dashboard</a>
        <hr>
        <a href="user_profile.php">User Profile</a>
        <hr>
        <a href="vehicle_registration.php">Vehicle Registration</a>
        <hr>
        <a href="user_manage_vehicle.php">Manage Vehicle</a>
        <hr>
        <a href="logout.php">Logout</a>
        <hr>
    </div>
    <div class="vehicleReg-content">
    <div class="vehicleReg-form">
        <h2>Vehicle Approval</h2>
        <table width="100%">
            <thead>
                <tr>
                    <!-- <th>Name</th>
                    <th>Phone Number</th> -->
                    <th>Vehicle Type</th>
                    <th>Plate Number</th>
                    <th>Model</th>
                    <th>Color</th>
                    <th>Grant</th>
                    <th>QR</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT u.*, v.*
                        FROM users u
                        JOIN vehicles v ON u.UserID = v.UserID
                        WHERE u.Username = '$currentUser' ";
                $run = mysqli_query($con, $sql);

                $target_path = 'vehicleGrant/';

                if($run) {
                    if(mysqli_num_rows($run) > 0) {
                        while ($row = mysqli_fetch_array($run)){
                            ?>
                            <tr>
                                <td><?php echo $row['VehicleType']?></td>
                                <td><?php echo $row['VehiclePlate']?></td>
                                <td><?php echo $row['VehicleModel']?></td>
                                <td><?php echo $row['VehicleColor']?></td>
                                <td><?php echo "<a href=" . $target_path . $row['VehicleGrant'] . "> {$row['VehicleGrant']}</a>"; ?></td>
                                <td>
                                    <?php 

                                    $vehicleSticker = "SELECT qr.*, vs.*
                                                        FROM qrcode qr
                                                        JOIN vehiclestickers vs ON qr.VehicleStickerID = vs.VehicleStickerID
                                                        WHERE vs.VehicleID = '".$row['VehicleID']."' ";

                                    $get = mysqli_query($con, $vehicleSticker);
                                    $qr = mysqli_fetch_array($get);

                                    
                                    ?>

                                    <img src="<?php echo $qr['QRCodeImage'] ?>">
                                </td>
                            </tr>
                        <?php
                        }
                    }
                }
                else {
                    echo "<tr><td colspan='9'>No vehicle found</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>
</body>
</html>