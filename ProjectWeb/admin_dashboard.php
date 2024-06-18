<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: login.php");
    exit();
}
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
        .events-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            z-index: 9999;
        }
        .events-table th, .events-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            z-index: 9999;
        }
        .events-table th {
            background-color: #f2f2f2;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <header>
        <h1>Administrator Dashboard - FKPark</h1>
    </header>
    <div class="dashboard">
    <div class="sidebar">
                <hr>
                <a href="admin_dashboard.php">Dashboard</a>
                <hr>
                <a href="admin_register.php">Register User</a>
                <hr>
                <a href="admin_parking_dashboard.php">Manage Parking</a>
                <hr>
                <a href="admin_manage_user.php">Manage User</a>
                <hr>
                <a href="admin_manage_vehicle.php">Manage Vehicle</a>
                <hr>
                <a href="logout.php">Logout</a>
                <hr>
            </div>
        <div class="content">
            <h2>Welcome, Administrator!</h2>
            <p>This is your dashboard. You can manage users, register new users, manage vehicles, and more.</p>
        </div>
        <div class="chart-container">
            <div class="chart">
                <h3>Staff Parking Space</h3>
                <canvas id="staffParkingChart" width="200" height="200"></canvas>
                <p>Used: 148, Empty: 52</p>
            </div>
            <div class="chart">
                <h3>Student Parking Space</h3>
                <canvas id="studentParkingChart" width="200" height="200"></canvas>
                <p>Used: 169, Empty: 31</p>
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
                data: [148, 52],
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
                data: [169, 31],
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

