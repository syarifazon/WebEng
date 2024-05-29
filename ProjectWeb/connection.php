<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "9801";
$db_name = "fkpark";

$con = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>