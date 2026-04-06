<?php
// database.php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // XAMPP default username
define('DB_PASS', '');            // XAMPP default password (empty)
define('DB_NAME', 'flickfinder');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
