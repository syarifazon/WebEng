<?php
$servername = "localhost";
$username = "root";
$password = "9801"; /* for haiqal only: $password = "9801"; */
$database = "fkpark";

// Create connection
 /* for haiqal only $con = new mysqli($servername, $username, null, $database, 3310); */
$con = new mysqli($servername, $username, null, $database, 3310);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>