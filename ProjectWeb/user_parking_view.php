<?php
require_once('connection.php');

// Fetch the data from the ParkingSpace table
$sql = "SELECT * FROM ParkingSpace";
$result = $con->query($sql);

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Dashboard - FKPark</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            z-index: 1;
            top: 0;
            /* Adjust the value to lower the sidebar */
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

        .table-container {
            margin-top: 20px;
            margin-left: 220px;
            font-family: "Trebuchet MS", sans-serif;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            text-align: left;
        }

        table th, table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #37C8BB;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <header>
        <h1>User Parking Dashboard - FKPark</h1>
    </header>
    <div class="dashboard">
        <div class="sidebar">
            <hr>
            <a href="user_dashboard.php">Return</a>
            <hr>
            <a href="Logout.php">Logout</a>
            <hr>
        </div>

        <div class="table-container">
            <h2>Parking Spaces</h2>
            <table>
                <thead>
                    <tr>
                        <th>Parking Space ID</th>
                        <th>Number of Spaces</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['ParkingSpaceID']}</td>
                                    <td>{$row['NumberOfSpace']}</td>
                                    <td>" . ($row['Status'] ? 'Available' : 'Not Available') . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No parking spaces found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    
        <div class="footer">
            <p>&copy; 2024 FKPark</p>
        </div>
    </div>
</body>
</html>