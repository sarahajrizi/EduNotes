<?php
$host = "127.0.0.1:3307";
$user = "root";
$password = "";
$dbname = "edunotes";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Lidhja deshtoi: " . $conn->connect_error);
}
?>

