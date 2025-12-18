<?php
require 'config.php';
$query = "delete from doctors where doctor_id = ?";
$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $_GET['doctor_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
if($_GET['doctor_id']){
    header('location:doctors.php');
}
