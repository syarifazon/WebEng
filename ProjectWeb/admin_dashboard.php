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
            <h1>Administrator Dashboard - FKPark</h1>
            <div class="nav-links">
                <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="admin_register.php"><i class="fas fa-user-plus"></i> Register User</a>
                <a href="admin_parking_dashboard.php"><i class="fas fa-tachometer-alt"></i> Managage Parking</a>
                <a href="admin_manage_user.php"><i class="fas fa-users-cog"></i> Manage User</a>
                <a href="admin_manage_vehicle.php"><i class="fas fa-car"></i> Manage Vehicle</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </header>
    <div class="dashboard">
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
        <div class="event_chart">
            <h3>Faculty of Computing Events</h3>
            <table class="events-table">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jamuan Raya</td>
                        <td>24 April 2024</td>
                        <td>10.00 a.m - 2.00 p.m</td>
                    </tr>
                    <tr>
                        <td>Window Cleaning Maintenance Left Wing</td>
                        <td>3 May 2024</td>
                        <td>10.00 a.m - 12.00 p.m</td>
                    </tr>
                    <tr>
                        <td>Window Cleaning Maintenance Right Wing</td>
                        <td>3 May 2024</td>
                        <td>2.00 p.m - 4.00 p.m</td>
                    </tr>
                </tbody>
            </table>
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

