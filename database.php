<?php

$servername = "localhost";
$username = "root";
$password = "root";
$database = "mydatabase";
$port = 3306; // Change this to the actual port number if it's different

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database, $port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";


?>