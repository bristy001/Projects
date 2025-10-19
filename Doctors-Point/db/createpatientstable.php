<?php
include './config.php';
// SQL query to create the 'doctors' table
$patientstableQuery = "CREATE TABLE IF NOT EXISTS patients (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    doctorName VARCHAR(100) NOT NULL,
    appointmentDay VARCHAR(20)  NOT NULL,
    patientName VARCHAR(100) NOT NULL,
    patientAge INT(3) NOT NULL
)";

// Execute the query
if (mysqli_query($myconnect, $patientstableQuery)) {
    echo "Table 'patients' created successfully.<br>";
} else {
    echo "Error creating table: " . mysqli_error($myconnect);
}
?>