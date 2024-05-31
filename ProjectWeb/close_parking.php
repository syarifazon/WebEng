<?php
require_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = $con->real_escape_string($_POST['event_name']);
    $eventDate = $con->real_escape_string($_POST['event_date']);
    $startTime = $con->real_escape_string($_POST['time_start']);
    $endTime = $con->real_escape_string($_POST['time_end']);
    $numberOfSpace = $con->real_escape_string($_POST['number_of_space']);
    $parkingSpaceID = $con->real_escape_string($_POST['parking_id']);

    $sql = "INSERT INTO CloseParking (EventName, EventDate, StartTime, EndTime, NumberOfSpace, ParkingSpaceID) 
            VALUES ('$eventName', '$eventDate', '$startTime', '$endTime', '$numberOfSpace', '$parkingSpaceID')";
    
    if ($con->query($sql) === TRUE) {
        echo "<script type='text/javascript'>alert('Parking space has been successfully closed');</script>";
    } 
    else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

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

        .form {
        background-color: white;
        padding: 20px;
        padding-bottom: 40px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 450px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
        margin-left: 40%;
        font-family: "Trebuchet MS", sans-serif ;
        }

        .form label {
        display: block;
        margin-bottom: 5px;
        color: #333;
        width: 400px;
        }

        .form input[type="text"] {
        width: 95%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        }

        .form button[type="submit"] {
        background-color: #37C8BB;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        border-radius: 4px;
        cursor: pointer;
        }

        .form button[type="submit"]:hover {
        background-color: #45a049;
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
        <a href="admin_dashboard.php">Return</a>
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
    <div class="form">
        <h2>Close Parking Space</h2>
        <form action="close_parking.php" method="POST">
            <label for="event_name">Event Name:</label><br>
            <input type="text" id="event_name" name="event_name" required><br><br>

            <label for="event_date">Event Date:</label><br>
            <input type="date" id="event_date" name="event_date" required><br><br>

            <label for="time_start">Start Time:</label><br>
            <input type="time" id="time_start" name="time_start" required><br><br>

            <label for="time_end">End Time:</label><br>
            <input type="time" id="time_end" name="time_end" required><br><br>

            <label for="number_of_space">Number of Parking Spaces:</label><br>
            <input type="number" id="number_of_space" name="number_of_space" required><br><br>

            <label for="parking_id">Parking Space ID:</label><br>
            <input type="text" id="parking_id" name="parking_id" required><br><br>

            <button type="submit">Close Parking</button>
        </form>
    </div>
    
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>
    </div>
    
</body>
</html>