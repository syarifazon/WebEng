<?php 
include('connection.php');
session_start();

if(isset($_POST['submit'])) {
    $userId = $_POST['userID'];
    $userName = $_POST['userFullName'];
    $vehiclePlate = $_POST['vehiclePlate'];
    $vehicleModel = $_POST['vehicleModel'];
    $vehicleType = $_POST['vehicleType'];
    $vehicleColor = $_POST['vehicleColor'];

    // Generate a unique file name without spaces
    $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    $vehicleGrant = uniqid() . '.' . $extension;
 
    #temporary file name to store file
    $tname = $_FILES["file"]["tmp_name"];
   
     #upload directory path
    $uploads_dir = 'vehicleGrant';
    #TO move the uploaded file to specific location
    move_uploaded_file($tname, $uploads_dir.'/'.$vehicleGrant);

    $sql = mysqli_query($con, "SELECT * FROM vehicles WHERE VehiclePlate='$vehiclePlate'");
    if (mysqli_num_rows($sql) > 0) {
        echo("<script>alert('Vehicle Already Exists')</script>");
        echo("<script>window.location = 'vehicle_registration.php';</script>");
    } 
    else {
        $query = "INSERT INTO vehicles (VehicleType, VehiclePlate, VehicleGrant, VehicleColor, VehicleModel, UserID) VALUES ('$vehicleType', '$vehiclePlate', '$vehicleGrant', '$vehicleColor',  '$vehicleModel', '$userId')";	
        $run = mysqli_query($con, $query);

        if($run) {

            //status:
            // pending => 0
            // approved => 1

            $findVehicleID = "SELECT VehicleID FROM vehicles WHERE vehicle";

            $addStatus = "INSERT INTO registrationvehicle (Status, Date, UserID, VehicleID) VALUES (0, CURRENT_TIMESTAMP, '$userId', LAST_INSERT_ID()) ";
            $result = mysqli_query($con, $addStatus);

            echo "<script type='text/javascript'> window.alert('Vehicle registration successful!') </script>";
            echo "<script type='text/javascript'> window.location='vehicle_registration.php' </script>";
        }
        else {
            echo "<script type='text/javascript'> window.alert('Vehicle registration Failed. Please try again') </script>";
            echo "<script type='text/javascript'> window.location='vehicle_registration.php' </script>";
        }

    }


}

?>