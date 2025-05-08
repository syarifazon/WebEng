<?php
 
include('connection.php');
session_start();
$currentUser = $_SESSION['username'];

 
// |-----------------------------------------------------------------------
// |   FUNCTION : Data from staff
// |-----------------------------------------------------------------------
 
// if($_GET['getstaff'])
// {
//     $sql = "SELECT * FROM staff";
//     $result = $db->query($sql);
//     $result = $result->fetch_all(MYSQLI_ASSOC);
 
//     echo json_encode($result);
//     die;
// }
 
// |-----------------------------------------------------------------------
// |   FUNCTION : Data from Profict
// |-----------------------------------------------------------------------
 

if($_GET['gettop'])
{

    $sql = "SELECT COUNT(v.VehicleID) as totalvehicle, v.VehicleType as typevehicle
            FROM `vehicles` v
            JOIN users u ON v.UserID = u.UserID
            WHERE u.Username = '$currentUser'
            GROUP BY VehicleType";
    $result = $con->query($sql);
    $result = $result->fetch_all(MYSQLI_ASSOC);
 
 
    foreach($result as $row)
    {
        $totalvehicle[] = $row['totalvehicle'];
        $typevehicle[] = $row['typevehicle'];
    }
 
    echo json_encode([
        "totalvehicle" => $totalvehicle,
        "typevehicle" => $typevehicle,
    ]);
    die;
}
 
 
?>