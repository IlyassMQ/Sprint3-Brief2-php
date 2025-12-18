<?php
include "config.php";
/* ADD DEPARTEMENT */
if (isset($_POST['add_departement'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "INSERT INTO departments ( name , description )
              VALUES ('$name', '$description')";
    mysqli_query($conn, $query);
}