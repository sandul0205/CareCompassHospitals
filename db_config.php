<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_compass_hospital";
$port = 4306; 

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
