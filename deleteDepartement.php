<?php
require 'config.php';
$query = "delete from departments where department_id = ?";
$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $_GET['department_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
if($_GET['department_id']){
    header('location:departement.php');
}
