<?php 
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "doctorspointdb";
// Create connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpassword);

$dbCreateQuery = "CREATE DATABASE IF NOT EXISTS $dbname";
$result = mysqli_query($conn, $dbCreateQuery);
if(!$result) {
    die("Database creation failed: " . mysqli_error($conn));
} else {
    echo "Database '$dbname' created successfully.<br>";
}
?>