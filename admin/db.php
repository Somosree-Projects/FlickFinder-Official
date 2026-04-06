<?php
$con = mysqli_connect("localhost", "root", "", "flickfinder");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
