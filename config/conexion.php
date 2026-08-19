<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "sistema_itmd";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión a MySQL: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>