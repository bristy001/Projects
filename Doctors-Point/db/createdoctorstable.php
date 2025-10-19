<?php
include './config.php';
// SQL query to create the 'doctors' table
$doctorstableQuery = "CREATE TABLE IF NOT EXISTS doctors (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    doctorName VARCHAR(100) NOT NULL,
    specialistAt VARCHAR(100) NOT NULL,
    fees INT(50) NOT NULL,
    imageURL VARCHAR(255) NOT NULL
)";

// Execute the query
if (mysqli_query($myconnect, $doctorstableQuery)) {
    echo "Table 'doctors' created successfully.<br>";
} else {
    echo "Error creating table: " . mysqli_error($myconnect);
}
?>