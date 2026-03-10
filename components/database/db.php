<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "teatro";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
