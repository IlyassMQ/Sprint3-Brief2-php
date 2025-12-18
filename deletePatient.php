<?php
require 'config.php';
$query = "delete from patients where patient_id = ?";
$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $_GET['patient_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
if($_GET['patient_id']){
    header('location:patients.php');
}
