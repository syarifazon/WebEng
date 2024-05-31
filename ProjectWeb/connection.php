<?php
$servername = "localhost";
$username = "root";
$password = ""; /* for other group member: $password = "9801"; */
$database = "fkpark";

// Create connection
 /* $con = new mysqli($servername, $username, null, $database, 3310); */
$con = new mysqli($servername, $username, $password, $database);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>