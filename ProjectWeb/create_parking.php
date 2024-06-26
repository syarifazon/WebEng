<?php 
require_once('connection.php');
include("../phpqrcode/qrlib.php");
session_start();

$PNG_TEMP_DIR = 'qr-image/';
if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);

$qrImage = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numberOfSpace = $con->real_escape_string($_POST['number_of_space']);
    $status = $con->real_escape_string($_POST['status']);

    $sql = "INSERT INTO ParkingSpace (NumberOfSpace, Status) 
            VALUES ('$numberOfSpace', '$status')";
    
    if ($con->query($sql) === TRUE) {
        // Get the last inserted ID
        $parkingSpaceID = $con->insert_id;

        // Generate QR code
        $codeString = "Parking Space ID: " . $parkingSpaceID . "\n";
        $codeString .= "Number of Spaces: " . $numberOfSpace . "\n";
        $codeString .= "Status: " . ($status == 1 ? 'Available' : 'Not Available');

        $filename = $PNG_TEMP_DIR . 'parkingSpace' . md5($codeString) . '.png';

        QRcode::png($codeString, $filename);

        // Insert QR code information into qrcode table
        $addQr = "INSERT INTO qrcode (QRCodeImage, ParkingSpaceID) VALUES ('$filename', '$parkingSpaceID')";
        if ($con->query($addQr) === TRUE) {
            echo "<script type='text/javascript'>alert('Parking space has been successfully created and QR code generated');</script>";
            $qrImage = $filename;
        } else {
            echo "Error: " . $addQr . "<br>" . $con->error;
        }
    } else {
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
            font-family: "Trebuchet MS", sans-serif;
        }

        .form label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            width: 400px;
        }

        .form input[type="text"],
        .form select {
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

        .qr-image {
            margin-top: 20px;
        }

        .qr-image img {
            border: 1px solid #ccc;
            padding: 10px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            <h2>Create Parking Space</h2>
            <form action="create_parking.php" method="POST">
                <label for="number_of_space">Number of Spaces:</label><br>
                <input type="text" id="number_of_space" name="number_of_space" required><br><br>

                <label for="status">Status:</label><br>
                <select id="status" name="status" required>
                    <option value="1">Available</option>
                    <option value="0">Not Available</option>
                </select><br><br>

                <button type="submit">Create</button>
            </form>
            <?php if (!empty($qrImage)): ?>
        <div class="qr-image">
            <h3>Generated QR Code for Parking Space:</h3>
            <img src="<?php echo $qrImage; ?>" alt="QR Code">
        </div>
        <?php endif; ?>
        </div>
    
        <div class="footer">
            <p>&copy; 2024 FKPark</p>
        </div>
    </div>
</body>
</html>

