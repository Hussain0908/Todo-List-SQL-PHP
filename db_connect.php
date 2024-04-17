<?php

$servername = "localhost"; // Change this to your MySQL server name if it's different
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = ""; // Change this to the name of your MySQL database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>