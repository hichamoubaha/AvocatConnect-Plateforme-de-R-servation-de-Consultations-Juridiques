<?php
$host = 'localhost'; // or your database host
$dbname = 'avocat_connect';
$username = 'root'; // replace with your database username
$password = ''; // replace with your database password

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
