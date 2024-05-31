<?php
require_once('connection.php');

// Fetch data for staff parking
$sqlStaff = "SELECT COUNT(*) AS total FROM ParkingSpace WHERE Status = 1 AND UserID IN (SELECT UserID FROM users WHERE UserCategory = 'staff')";
$resultStaff = $con->query($sqlStaff);
$rowStaff = $resultStaff->fetch_assoc();
$staffUsed = $rowStaff['total'];
$staffEmpty = 200 - $staffUsed; // Assuming there are 200 total staff parking spaces

// Fetch data for student parking
$sqlStudent = "SELECT COUNT(*) AS total FROM ParkingSpace WHERE Status = 1 AND UserID IN (SELECT UserID FROM users WHERE UserCategory = 'student')";
$resultStudent = $con->query($sqlStudent);
$rowStudent = $resultStudent->fetch_assoc();
$studentUsed = $rowStudent['total'];
$studentEmpty = 200 - $studentUsed; // Assuming there are 200 total student parking spaces

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Dashboard - FKPark</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6Gvk/e3s4Wz6iJgD/+ub2oU" crossorigin="anonymous">
    <style>
        .chart-container {
            display: flex;
            justify-content: space-between;
            margin-left: 220px;
        }
        .chart {
            width: 35%;
        }
        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            z-index: 1;
            top: 0; /* Adjust the value to lower the sidebar */
            left: 0;
            background-color: #4E4E4E;
            overflow-x: hidden;
            padding-top: 69px;
            bottom: 0;
            overflow: auto;
            opacity: 0.6;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #f1f1f1;
            display: block;
        }

        .sidebar a:hover {
            color: #37C8BB;
        }
        
    </style>
    
</head>
<body>
    <header>
        <h1>Administrator Parking Dashboard - FKPark</h1>
    </header>
    <div class="dashboard">
    <div class="sidebar">
        <hr>
        <a href="admin_dashboard.php">Dashboard</a>
        <hr>
        <a href="admin_view_parking.php">View Parking</a>
        <hr>
        <a href="create_parking.php">Create Parking</a>
        <hr>
        <a href="update_parking.php">Update Parking</a>
        <hr>
        <a href="delete_parking.php">Delete Parking</a>
        <hr>
        <a href="close_parking.php">Close Parking Space</a>
        <hr>
        <a href="logout.php">Logout</a>
        <hr>
    </div>
    <div class="content">
    <h2>Welcome, Administrator!</h2>
        <p>This is your parking dashboard. You can now manage the parking space in Faculty of Computing</p>
    </div>
    <div class="chart-container">
            <div class="chart">
                <h3>Staff Parking Space</h3>
                <canvas id="staffParkingChart" width="200" height="200"></canvas>
                <p>Used: , Empty: </p>
            </div>
            <div class="chart">
                <h3>Student Parking Space</h3>
                <canvas id="studentParkingChart" width="200" height="200"></canvas>
                <p>Used: , Empty: </p>
            </div>
        </div>
    
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>
    </div>
    <script>
        // Staff Parking Space chart
        const staffParkingData = {
            labels: ['Used', 'Empty'],
            datasets: [{
                label: 'Parking Space',
                data: [<?php echo $staffUsed; ?>, <?php echo $staffEmpty; ?>],
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        };

        const staffParkingConfig = {
            type: 'doughnut',
            data: staffParkingData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Staff Parking Space'
                    }
                }
            }
        };

        new Chart(document.getElementById('staffParkingChart'), staffParkingConfig);

        // Student Parking Space chart
        const studentParkingData = {
            labels: ['Used', 'Empty'],
            datasets: [{
                label: 'Parking Space',
                data: [<?php echo $studentUsed; ?>, <?php echo $studentEmpty; ?>],
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        };

        const studentParkingConfig = {
            type: 'doughnut',
            data: studentParkingData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Student Parking Space'
                    }
                }
            }
        };

        new Chart(document.getElementById('studentParkingChart'), studentParkingConfig);
    </script>
</body>
</html>