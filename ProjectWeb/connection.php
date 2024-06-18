<?php
$servername = "localhost";
$username = "root";
$password = ""; /* for haiqal only: $password = "9801"; */
$database = "fkpark";

// Create connection
 /* for haiqal only $conn = new mysqli($servername, $username, null, $database, 3310); */
 // others $con = new mysqli($servername, $username, $password, $database);
 $con = new mysqli($servername, $username, $password, $database);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>