<?php
include 'config/conexion.php';

$msg = "";

if (isset($_POST['ingresar'])) {
    $user = trim(mysqli_real_escape_string($conn, $_POST['usuario']));
    $pass = trim($_POST['password']);

    $query = "SELECT l.*, d.nombre FROM users_login l JOIN users_data d ON l.idUser = d.idUser WHERE l.usuario = '$user'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $usuario_db = mysqli_fetch_assoc($result);

        // VERIFICACIÓN A PRUEBA DE FALLOS:
        // Evalúa el hash de PHP O la coincidencia exacta si la BD acaba de importarse
        $es_valida = password_verify($pass, $usuario_db['password']) || ($pass === $usuario_db['password']);

        if ($es_valida) {
            // Si la contraseña estaba en texto plano en la BD, la encripta automáticamente en segundo plano
            if ($pass === $usuario_db['password']) {
                $hash_seguro = password_hash($pass, PASSWORD_DEFAULT);
                $idLogin = $usuario_db['idLogin'];
                mysqli_query($conn, "UPDATE users_login SET password = '$hash_seguro' WHERE idLogin = '$idLogin'");
            }

            $_SESSION['idUser']  = $usuario_db['idUser'];
            $_SESSION['usuario'] = $usuario_db['usuario'];
            $_SESSION['nombre']  = $usuario_db['nombre'];
            $_SESSION['rol']     = $usuario_db['rol'];

            if ($usuario_db['rol'] === 'admin') {
                header("Location: admin/usuarios-administracion.php");
            } else {
                header("Location: perfil.php");
            }
            exit();
        } else {
            $msg = "<div class='alert alert-error'>Credenciales incorrectas.</div>";
        }
    } else {
        $msg = "<div class='alert alert-error'>Credenciales incorrectas.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Iniciar Sesión</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <div class="form-card" style="max-width: 400px; margin: 60px auto;">
            <h2>Login</h2>
            <?= $msg; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Nombre de Usuario</label>
                    <input type="text" name="usuario" placeholder="ej: admin" required>
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" name="ingresar">Acceder al Portal</button>
            </form>
        </div>
    </div>
</body>
</html>