<?php

// Si ya hay sesión activa, redirigir al inicio
if (isset($_SESSION['idUser'])) {
    header("Location: index.php");
    exit();
}
include 'config/conexion.php'; 
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = mysqli_real_escape_string($conn, $_POST['usuario']);
    $pass = $_POST['password'];
    $sql = "SELECT l.*, d.nombre FROM users_login l JOIN users_data d ON l.idUser = d.idUser WHERE l.usuario = '$user'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    if ($row && password_verify($pass, $row['password'])) {
        $_SESSION['idUser'] = $row['idUser'];
        $_SESSION['rol'] = $row['rol'];
        $_SESSION['nombre'] = $row['nombre'];
        header("Location: index.php");
    } else { $error = "Credenciales incorrectas."; }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><link rel="stylesheet" href="css/style.css"></head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <div class="form-card">
            <h1>Login</h1>
            <?php if($error) echo "<div class='alert alert-error'>$error</div>"; ?>
            <form method="POST">
                <label>Nombre de Usuario</label>
                <input type="text" name="usuario" placeholder="ej: admin" required>
                <label>Contraseña</label>
                <input type="password" name="password" placeholder="••••••••" required>
                <button type="submit">Acceder al Portal</button>
            </form>
            <p style="margin-top: 20px; text-align: center; font-size: 0.9rem; color: var(--text-secondary);">
                ¿No tienes cuenta? <a href="registro.php" style="color: var(--accent);">Regístrate ahora</a>
            </p>
        </div>
    </div>
</body>
</html>