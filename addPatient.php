<?php
include "config.php";
/* ADD PATIENT */
if (isset($_POST['add_patient'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $gender     = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "INSERT INTO patients (first_name, last_name, gender, phone, email)
              VALUES ('$first_name', '$last_name', '$gender', '$phone', '$email')";
    mysqli_query($conn, $query);
}
