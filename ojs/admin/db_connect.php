<?php 

// Database connection with root as username and no password
$conn = new mysqli('localhost', 'root', '', 'jewelry_db');

// Check connection
if ($conn->connect_error) {
    die("Could not connect to MySQL: " . $conn->connect_error);
}  
?>
