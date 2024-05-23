<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Dashboard - FKPark</title>
    <link rel="stylesheet" href="styles.css">
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
        <a href="#">Manage User</a>
        <hr>
        <a href="#">Manage Vehicle</a>
        <hr>
        <a href="logout.php">Logout</a>
        <hr>
    </div>
    <div class="content">
    <h2>Welcome, Administrator!</h2>
        <p>This is your dashboard. You can manage users, register new users, manage vehicles, and more.</p>
    </div>
    <div class="stat_table">
        <h3>Staff Parking Space</h3>
        <table>
            <tr>
                <th>Used Parking Space</th>
                <th>Empty Parking Space</th>
            </tr>
            <tr>
                <td>148</td>
                <td>52</td>
            </tr>
        </table>
        <h3>Student Parking Space</h3>
        <table>
            <tr>
                <th>Used Parking Space</th>
                <th>Empty Parking Space</th>
            </tr>
            <tr>
                <td>169</td>
                <td>31</td>
            </tr>
        </table>
    </div>
    <div class="event_table">
    <h3>Faculting of Computing Events</h3>
        <table>
            <tr>
                <th>Event</th>
                <th>Date</th>
            </tr>
            <tr>
                <td>Jamuan Raya</td>
                <td>24 April 2024 [10.00 a.m - 2.00 p.m]</td>
            </tr>
            <tr>
                <td>Window Cleaning Maintenance Left Wing</td>
                <td>3 May 2024 [10.00 a.m - 12.00 p.m]</td>
            </tr>
            <tr>
                <td>Window Cleaning Maintenance Right Wing</td>
                <td>3 May 2024 [2.00 p.m - 4.00 p.m]</td>
            </tr>
        </table>
    </div>
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>
    </div>
</body>
</html>


