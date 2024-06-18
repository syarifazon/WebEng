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

        <!-- Datatables -->
        <link href="https://cdn.datatables.net/v/bs5/dt-1.13.5/fc-4.3.0/fh-3.4.0/datatables.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/fc-4.3.0/fh-3.4.0/datatables.min.js"></script>

        <!-- Jquery -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- Apex Chart -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>

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
        .user_functions{
            background-color: white;
            width: 50%;
            padding: 10px 20px;
            margin-left: 210px;
            margin-bottom: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <header>
        <!-- <div class="navbar"> -->
            <h1>User Dashboard - FKPark</h1>
            <!-- <div class="nav-links">
                <a href="user_dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                <a href="user_parking_view.php"><i class="fas fa-tachometer-alt"></i>Parking</a>
                <a href="user_profile.php"><i class="fas fa-user"></i>User Profile</a>
                <a href="vehicle_registration.php"><i class="fas fa-car"></i>Vehicle Registration</a>
                <a href="user_manage_vehicle.php"><i class="fas fa-car"></i>Manage Vehicle</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </div>
        </div> -->
    </header>
    <div class="sidebar">
        <hr>
        <a href="user_dashboard.php">Dashboard</a>
        <hr>
        <a href="user_parking_view.php">Parking</a>
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
    <div class="content-user-dashboard">
        
        <div class="dashboard">
        <h2 class="content">Welcome, <?php echo htmlspecialchars($user_data['UserFullname']); ?></h2>
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
                
                <section id="parking-availability">
                    <h2>Total Registered Vehicle</h2>
                    <!-- <canvas id="parking-availability-chart"></canvas> -->
                    <div id="chart_pie"></div>
                </section>


                <!-- <section id="parking-availability">
                    <h2>Parking Availability</h2> -->
                    <!-- <canvas id="parking-availability-chart"></canvas> -->
                    <!-- <div id="chart_pie2"></div>
                </section> -->
            </div>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="dashboardScript.js"></script>
</body>
</html>
<script>
 
$(document).ready(function() {

    /* ========================================================================== Ni coding utk pie chart */
    $.post('dashboardApi.php?gettop=1', {test: 123}, function (res) {
        console.log(res)
        var options = {
                series: res.totalvehicle,
                chart: {
                width: 535,
                type: 'pie',
            },
            labels: res.typevehicle,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
 
        var chart = new ApexCharts(document.querySelector("#chart_pie"), options);
        chart.render();
    }, 'json')
 
// });

/* ========================================================================== Ni coding utk line chart */
// $.post('VendorDashbApi.php?getannual=1', {test: 123}, function (res) {
//   console.log(res)
//         var options = {
//                 series: res.totalavailspace,
//                 chart: {
//                 width: 535,
//                 type: 'pie',
//             },
//             labels: res.totalunavailspace,
//             responsive: [{
//                 breakpoint: 480,
//                 options: {
//                     chart: {
//                         width: 200
//                     },
//                     legend: {
//                         position: 'bottom'
//                     }
//                 }
//             }]
//         };
 
//         var chart = new ApexCharts(document.querySelector("#chart_pie2"), options);
//         chart.render();
//     }, 'json')
 
});
 
</script>

