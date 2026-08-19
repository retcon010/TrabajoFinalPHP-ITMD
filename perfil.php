<?php 
include 'config/conexion.php'; 
if (!isset($_SESSION['idUser'])) { header("Location: login.php"); exit(); }

$idUsuario = $_SESSION['idUser'];
$msg = "";

if (isset($_POST['guardar_perfil'])) {
    $n = mysqli_real_escape_string($conn, $_POST['nombre']);
    $a = mysqli_real_escape_string($conn, $_POST['apellidos']);
    $e = mysqli_real_escape_string($conn, $_POST['email']);
    $t = mysqli_real_escape_string($conn, $_POST['telefono']);
    $fn = $_POST['fecha_nacimiento'];
    $d = mysqli_real_escape_string($conn, $_POST['direccion']);
    $s = $_POST['sexo'];

    $sql = "UPDATE users_data SET nombre='$n', apellidos='$a', email='$e', telefono='$t', fecha_nacimiento='$fn', direccion='$d', sexo='$s' WHERE idUser='$idUsuario'";
    if (mysqli_query($conn, $sql)) {
        $msg = "<div class='alert alert-success'>Perfil actualizado correctamente.</div>";
    } else {
        $msg = "<div class='alert alert-error'>Error al actualizar el perfil.</div>";
    }
}

$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users_data WHERE idUser='$idUsuario'"));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Mi Perfil</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <div class="form-card" style="max-width: 600px;">
            <h2>Mi Perfil</h2>
            <?= $msg; ?>
            <form method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" name="nombre" value="<?= $u['nombre'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Apellidos:</label>
                        <input type="text" name="apellidos" value="<?= $u['apellidos'] ?? ''; ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" value="<?= $u['email'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono:</label>
                        <input type="text" name="telefono" value="<?= $u['telefono'] ?? ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label>Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nacimiento" value="<?= $u['fecha_nacimiento'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Dirección:</label>
                    <input type="text" name="direccion" value="<?= $u['direccion'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Sexo:</label>
                    <select name="sexo">
                        <option value="Masculino" <?= (($u['sexo'] ?? '') == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                        <option value="Femenino" <?= (($u['sexo'] ?? '') == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                        <option value="Otro" <?= (($u['sexo'] ?? '') == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                    </select>
                </div>
                <button type="submit" name="guardar_perfil">Guardar Cambios</button>
            </form>
        </div>
    </div>
</body>
</html>