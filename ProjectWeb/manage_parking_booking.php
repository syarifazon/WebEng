<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Student') {
    header("location: login.php");
    die();
}
require_once('connection.php');
require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $bookingDateTime = $_POST['booking_datetime'];
                $duration = $_POST['duration'];
                $userID = $_POST['user_id'];
                $vehicleID = $_POST['vehicle_id'];
                $parkingSpaceID = $_POST['parking_space_id'];

                // Check if the UserID exists in the users table
                $userCheck = "SELECT * FROM users WHERE UserID='$userID'";
                $userResult = $con->query($userCheck);

                if ($userResult->num_rows == 0) {
                    echo "<script>alert('Error: User ID does not exist.');</script>";
                    break;
                }

                // Check if the VehicleID exists in the vehicles table
                $vehicleCheck = "SELECT * FROM vehicles WHERE VehicleID='$vehicleID'";
                $vehicleResult = $con->query($vehicleCheck);

                if ($vehicleResult->num_rows == 0) {
                    echo "<script>alert('Error: Vehicle ID does not exist.');</script>";
                    break;
                }

                // Check if the ParkingSpaceID exists in the parking_spaces table
                $parkingSpaceCheck = "SELECT * FROM parking_spaces WHERE ParkingSpaceID='$parkingSpaceID'";
                $parkingSpaceResult = $con->query($parkingSpaceCheck);

                if ($parkingSpaceResult->num_rows == 0) {
                    echo "<script>alert('Error: Parking Space ID does not exist.');</script>";
                    break;
                }

                $sql = "INSERT INTO manage_parking_booking (BookingDateTime, ExpectedParkingDuration, Status, UserID, VehicleID, ParkingSpaceID) 
                        VALUES ('$bookingDateTime', '$duration', TRUE, '$userID', '$vehicleID', '$parkingSpaceID')";
                if ($con->query($sql) === TRUE) {
                    $bookingID = $con->insert_id;

                    // Ensure the qrcodes directory exists
                    $qrDir = 'qrcodes';
                    if (!is_dir($qrDir)) {
                        mkdir($qrDir, 0755, true);
                    }

                    // Generate QR Code
                    $qrContent = "http://localhost/WebEng-main/ProjectWeb/manage_parking_booking_page.php?booking_id=$bookingID";
                    $qrCode = QrCode::create($qrContent)
                        ->setSize(100);
                    $writer = new PngWriter();
                    $qrFileName = "$qrDir/booking_$bookingID.png";
                    $writer->write($qrCode)->saveToFile($qrFileName);

                    echo "<script>alert('Booking added successfully. Booking ID: $bookingID');</script>";
                    echo "<img src='$qrFileName' alt='QR Code'>";
                } else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }
                break;

            case 'update':
                $bookingID = $_POST['booking_id'];
                $bookingDateTime = $_POST['booking_datetime'];
                $duration = $_POST['duration'];
                $userID = $_POST['user_id'];
                $vehicleID = $_POST['vehicle_id'];
                $parkingSpaceID = $_POST['parking_space_id'];

                $sql = "UPDATE manage_parking_booking SET BookingDateTime='$bookingDateTime', ExpectedParkingDuration='$duration', 
                        UserID='$userID', VehicleID='$vehicleID', ParkingSpaceID='$parkingSpaceID' WHERE BookingID='$bookingID'";
                if ($con->query($sql) === TRUE) {
                    echo "<script>alert('Booking updated successfully.');</script>";
                } else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }
                break;

            case 'delete':
                $bookingID = $_POST['booking_id'];
                $sql = "DELETE FROM manage_parking_booking WHERE BookingID='$bookingID'";
                if ($con->query($sql) === TRUE) {
                    echo "<script>alert('Booking deleted successfully.');</script>";
                } else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }
                break;
        }
    }
}

$sql = "SELECT * FROM manage_parking_booking";
$bookings = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Parking Booking - FKPark</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="navbar">
            <h1>Manage Parking Booking - FKPark</h1>
            <div class="nav-links">
                <a href="user_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="actions">
            <button onclick="showForm('addForm')">Add Booking</button>
            <button onclick="showForm('updateForm')">Update Booking</button>
            <button onclick="showForm('deleteForm')">Delete Booking</button>
            <button onclick="showForm('viewForm')">View Bookings</button>
        </div>
        <div class="forms">
            <div id="addForm" class="form-container" style="display:none;">
                <h2>Add Booking</h2>
                <form method="post" action="manage_parking_booking.php">
                    <input type="hidden" name="action" value="add">
                    <label for="booking_datetime">Booking DateTime:</label>
                    <input type="datetime-local" id="booking_datetime" name="booking_datetime" required><br>
                    <label for="duration">Duration (hours):</label>
                    <input type="number" id="duration" name="duration" required><br>
                    <label for="user_id">User ID:</label>
                    <input type="text" id="user_id" name="user_id" required><br>
                    <label for="vehicle_id">Vehicle ID:</label>
                    <input type="text" id="vehicle_id" name="vehicle_id" required><br>
                    <label for="parking_space_id">Parking Space ID:</label>
                    <input type="text" id="parking_space_id" name="parking_space_id" required><br>
                    <input type="submit" value="Add Booking">
                </form>
            </div>
            <div id="updateForm" class="form-container" style="display:none;">
                <h2>Update Booking</h2>
                <form method="post" action="manage_parking_booking.php">
                    <input type="hidden" name="action" value="update">
                    <label for="booking_id">Booking ID:</label>
                    <input type="text" id="booking_id" name="booking_id" required><br>
                    <label for="booking_datetime">Booking DateTime:</label>
                    <input type="datetime-local" id="booking_datetime" name="booking_datetime" required><br>
                    <label for="duration">Duration (hours):</label>
                    <input type="number" id="duration" name="duration" required><br>
                    <label for="user_id">User ID:</label>
                    <input type="text" id="user_id" name="user_id" required><br>
                    <label for="vehicle_id">Vehicle ID:</label>
                    <input type="text" id="vehicle_id" name="vehicle_id" required><br>
                    <label for="parking_space_id">Parking Space ID:</label>
                    <input type="text" id="parking_space_id" name="parking_space_id" required><br>
                    <input type="submit" value="Update Booking">
                </form>
            </div>
            <div id="deleteForm" class="form-container" style="display:none;">
                <h2>Delete Booking</h2>
                <form method="post" action="manage_parking_booking.php">
                    <input type="hidden" name="action" value="delete">
                    <label for="booking_id">Booking ID:</label>
                    <input type="text" id="booking_id" name="booking_id" required><br>
                    <input type="submit" value="Delete Booking">
                </form>
            </div>
            <div id="viewForm" class="form-container">
                <h2>Existing Bookings</h2>
                <table>
                    <tr>
                        <th>Booking ID</th>
                        <th>Booking DateTime</th>
                        <th>Duration</th>
                        <th>User ID</th>
                        <th>Vehicle ID</th>
                        <th>Parking Space ID</th>
                        <th>Actions</th>
                    </tr>
                    <?php if ($bookings->num_rows > 0): ?>
                        <?php while($row = $bookings->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['BookingID']; ?></td>
                                <td><?php echo $row['BookingDateTime']; ?></td>
                                <td><?php echo $row['ExpectedParkingDuration']; ?></td>
                                <td><?php echo $row['UserID']; ?></td>
                                <td><?php echo $row['VehicleID']; ?></td>
                                <td><?php echo $row['ParkingSpaceID']; ?></td>
                                <td>
                                    <button onclick="populateForm('<?php echo $row['BookingID']; ?>', '<?php echo $row['BookingDateTime']; ?>', '<?php echo $row['ExpectedParkingDuration']; ?>', '<?php echo $row['UserID']; ?>', '<?php echo $row['VehicleID']; ?>', '<?php echo $row['ParkingSpaceID']; ?>')">Edit</button>
                                    <form method="post" action="manage_parking_booking.php" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="booking_id" value="<?php echo $row['BookingID']; ?>">
                                        <input type="submit" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No bookings found.</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 FKPark</p>
    </div>

    <script>
        function showForm(formId) {
            var forms = document.getElementsByClassName('form-container');
            for (var i = 0; i < forms.length; i++) {
                forms[i].style.display = 'none';
            }
            document.getElementById(formId).style.display = 'block';
        }

        function populateForm(bookingID, bookingDateTime, duration, userID, vehicleID, parkingSpaceID) {
            showForm('updateForm');
            document.getElementById('booking_id').value = bookingID;
            document.getElementById('booking_datetime').value = bookingDateTime;
            document.getElementById('duration').value = duration;
            document.getElementById('user_id').value = userID;
            document.getElementById('vehicle_id').value = vehicleID;
            document.getElementById('parking_space_id').value = parkingSpaceID;
        }
    </script>
</body>
</html>

