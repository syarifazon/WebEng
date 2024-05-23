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
            background-color: #333;
            padding: 10px;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 5px;
            display: flex;
            align-items: center;
        }
        .navbar a:hover {
            background-color: #555;
        }
        .navbar i {
            margin-right: 5px;
        }
        .nav-links {
            position: absolute;
            bottom: 0;
            right: 0;
            padding: 10px;
            background-color: #333;
            display: flex;
            justify-content: space-between;
        }
        .nav-links a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <h1>Administrator Dashboard - FKPark</h1>
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
            <h3>Faculting of Computing Events</h3>
            <ul>
                <li>Jamuan Raya - 24 April 2024 [10.00 a.m - 2.00 p.m]</li>
                <li>Window Cleaning Maintenance Left Wing - 3 May 2024 [10.00 a.m - 12.00 p.m]</li>
                <li>Window Cleaning Maintenance Right Wing - 3 May 2024 [2.00 p.m - 4.00 p.m]</li>
            </ul>
        </div>
        <div class="footer">
            <p>&copy; 2024 FKPark</p>
            <div class="nav-links">
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                <a href="admin_register.php"><i class="fas fa-user-plus"></i>Register User</a>
                <a href="#"><i class="fas fa-users-cog"></i>Manage User</a>
                <a href="#"><i class="fas fa-car"></i>Manage Vehicle</a>
            </div>
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

