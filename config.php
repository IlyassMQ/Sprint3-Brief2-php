<?php
$serverName = 'localhost';
$username = 'root';
$password = '';
$db = 'unitycareclinic';
$conn = mysqli_connect($serverName, $username, $password, $db
);
if(!$conn){
    die('Connection Failed' . mysqli_connect_error());
}
?>