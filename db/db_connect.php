<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "eatopia";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
