<?php
$servername = "localhost"; // Change if you're not using localhost
$username = "root";        // Your database username
$password = "";            // Your database password
$dbname = "flickfinder";   // Your database name

// Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
