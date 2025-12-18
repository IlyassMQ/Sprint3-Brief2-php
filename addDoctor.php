<?php
include "config.php";
/* ADD DOCTOR */
if (isset($_POST['add_doctor'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $department_id = (int) $_POST['department_id'];


    $query = "INSERT INTO doctors (first_name, last_name, phone, email, department_id)
VALUES ('$first_name', '$last_name', '$phone', '$email', $department_id)";
    mysqli_query($conn, $query);
}