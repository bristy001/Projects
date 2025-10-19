<?php 
include '../db/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctorName = $_POST['doctorName'];
    $specialistAt = $_POST['Specialist'];
    $fees = $_POST['fees'];
    $imageURL = $_POST['imageURL'];

    $insertQuery = "INSERT INTO doctors (doctorName, specialistAt, fees, imageURL) VALUES ('$doctorName', '$specialistAt', '$fees', '$imageURL')";
    
    if (mysqli_query($myconnect, $insertQuery)) {
        header("Location: ../admin.php");
    } else {
        echo "Error: " . mysqli_error($myconnect);
    }
}
?>