<?php
$servername = "db";
$username = "root";
$password = "rootpassword";
$dbname = "biblioteca_digital";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
