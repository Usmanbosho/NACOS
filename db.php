<?php
$host = "localhost"; // or 127.0.0.1
$user = "root";      // your database username
$pass = "";          // your database password
$dbname = "nacos_db"; // your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>