<?php 
include('connection.php');
include("../phpqrcode/qrlib.php");
session_start();

$PNG_TEMP_DIR = 'qr-image/';
if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);


if(isset($_POST['submit'])) {
    
    echo $regvehId = $_POST['regvehicleid'];

    $sql = "SELECT u.*, rv.*
            FROM users u
            JOIN registrationvehicle rv ON u.UserID = rv.UserID
            WHERE RegistrationVehicleID = '$regvehId' ";
    $result = mysqli_query($con,$sql);

    $user = mysqli_fetch_array($result);

    // echo $user['UserFullname'];
    // echo $user['UserContact'];

    $sql2 = "SELECT v.*, rv.*
            FROM vehicles v
            JOIN registrationvehicle rv ON v.VehicleID = rv.VehicleID
            WHERE rv.RegistrationVehicleID = '$regvehId' ";
    $result2 = mysqli_query($con,$sql2);

    $vehicle = mysqli_fetch_array($result2);

    // echo $vehicle['VehicleType'];
    // echo $vehicle['VehiclePlate'];
    // echo $vehicle['VehicleColor'];
    // echo $vehicle['VehicleModel'];


    //=================================================================================================
    $sql="UPDATE registrationvehicle SET Status = 1 WHERE RegistrationVehicleID = '$regvehId'";
    
    if(mysqli_query($con,$sql)) {

        $future_date = date('Y-m-d', strtotime("now + 1 years"));
        //echo $future_date;

        $addSticker = "INSERT INTO vehiclestickers (StickerType, ExpiryDate, UserID, VehicleID) VALUES ('".$vehicle['VehicleType']."', '$future_date', '".$user['UserID']."', '".$vehicle['VehicleID']."') ";
        $run = mysqli_query($con, $addSticker);

        if($run) {
            
            if(isset($_POST['submit'])) {

                $filename = $PNG_TEMP_DIR . 'vehicleSticker.png';

                $getExpiryDate = "SELECT ExpiryDate FROM vehiclestickers WHERE VehicleStickerID = LAST_INSERT_ID() ";
                $get = mysqli_query($con, $getExpiryDate);

                $expiryDate = mysqli_fetch_array($get);

                $codeString = "UMPSA VEHICLE STICKER" . "\n";
                $codeString .= $user['UserFullname'] . "\n";
                $codeString .= $user['UserContact'] . "\n";
                $codeString .= $vehicle['VehicleType'] . "\n";
                $codeString .= $vehicle['VehiclePlate'] . "\n";
                $codeString .= $vehicle['VehicleColor'] . "\n";
                $codeString .= $vehicle['VehicleModel'] . "\n";
                $codeString .= $expiryDate['ExpiryDate'];

                $filename = $PNG_TEMP_DIR . 'vehicleSticker' . md5($codeString) . '.png';

                QRcode::png($codeString, $filename);
            }

            $addQr = "INSERT INTO qrcode (QRCodeImage, VehicleStickerID, UserID) VALUES ('$filename', LAST_INSERT_ID(), '".$user['UserID']."')";
            $runQr = mysqli_query($con, $addQr);

        }

        echo '<script>alert("Vehicle approved!")</script>';
        echo("<script>window.location = 'staff_manage_vehicle.php';</script>");
    }
    else {
        echo "Error updating status ".mysqli_error($con); // display error message if not delete
    }
    
}

?>