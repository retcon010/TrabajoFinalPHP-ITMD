<?php 
include '../config/conexion.php'; 
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') { header("Location: ../index.php"); exit(); }

$id = $_GET['id'];
$msg = "";

if (isset($_POST['actualizar'])) {
    $n = mysqli_real_escape_string($conn, $_POST['nombre']); 
    $a = mysqli_real_escape_string($conn, $_POST['apellidos']); 
    $e = mysqli_real_escape_string($conn, $_POST['email']);
    $t = mysqli_real_escape_string($conn, $_POST['telefono']);
    $fn = $_POST['fecha_nacimiento'];
    $d = mysqli_real_escape_string($conn, $_POST['direccion']);
    $s = $_POST['sexo'];
    $r = $_POST['rol'];
    
    mysqli_query($conn, "UPDATE users_data SET nombre='$n', apellidos='$a', email='$e', telefono='$t', fecha_nacimiento='$fn', direccion='$d', sexo='$s' WHERE idUser='$id'");
    mysqli_query($conn, "UPDATE users_login SET rol='$r' WHERE idUser='$id'");
    $msg = "<div class='alert alert-success'>Usuario actualizado correctamente.</div>";
}

$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT d.*, l.rol FROM users_data d JOIN users_login l ON d.idUser = l.idUser WHERE d.idUser='$id'"));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Editar Usuario</title>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <div class="form-card">
            <h2>Editar Perfil Completo de Usuario</h2>
            <?= $msg; ?>
            <form method="POST">
                <div class="form-row">
                    <div class="form-group"><label>Nombre:</label><input type="text" name="nombre" value="<?= $u['nombre']; ?>" required></div>
                    <div class="form-group"><label>Apellidos:</label><input type="text" name="apellidos" value="<?= $u['apellidos']; ?>" required></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Email:</label><input type="email" name="email" value="<?= $u['email']; ?>" required></div>
                    <div class="form-group"><label>Teléfono:</label><input type="text" name="telefono" value="<?= $u['telefono']; ?>"></div>
                </div>
                <div class="form-group"><label>Fecha de Nacimiento:</label><input type="date" name="fecha_nacimiento" value="<?= $u['fecha_nacimiento']; ?>" required></div>
                <div class="form-group"><label>Dirección:</label><input type="text" name="direccion" value="<?= $u['direccion']; ?>"></div>
                <div class="form-group">
                    <label>Sexo:</label>
                    <select name="sexo">
                        <option value="Masculino" <?= ($u['sexo']=='Masculino')?'selected':''; ?>>Masculino</option>
                        <option value="Femenino" <?= ($u['sexo']=='Femenino')?'selected':''; ?>>Femenino</option>
                        <option value="Otro" <?= ($u['sexo']=='Otro')?'selected':''; ?>>Otro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Rol:</label>
                    <select name="rol">
                        <option value="user" <?= ($u['rol']=='user')?'selected':''; ?>>User</option>
                        <option value="admin" <?= ($u['rol']=='admin')?'selected':''; ?>>Admin</option>
                    </select>
                </div>
                <button type="submit" name="actualizar">Guardar Cambios</button>
                <div style="text-align: center; margin-top: 15px;">
                    <a href="usuarios-administracion.php" class="link-cancel">Volver a Usuarios</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>