<?php
// Si estás en XAMPP, usa 'localhost'. Si estás en Docker, usa 'db'.
$host = "localhost"; 
$user = "root";
$pass = ""; // Si usas Docker es 'root_password'
$db   = "sistema_itmd";

// Intentamos la conexión
try {
    $conn = mysqli_connect($host, $user, $pass, $db);
} catch (mysqli_sql_exception $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Iniciamos sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>