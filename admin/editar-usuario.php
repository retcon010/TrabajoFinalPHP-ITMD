<?php 
include '../config/conexion.php'; 
if ($_SESSION['rol'] != 'admin') { header("Location: ../index.php"); exit(); }

$id = $_GET['id'];
$msg = "";

if (isset($_POST['actualizar'])) {
    $n = $_POST['nombre']; $a = $_POST['apellidos']; $r = $_POST['rol'];
    mysqli_query($conn, "UPDATE users_data SET nombre='$n', apellidos='$a' WHERE idUser='$id'");
    mysqli_query($conn, "UPDATE users_login SET rol='$r' WHERE idUser='$id'");
    $msg = "<p class='success'>Usuario actualizado.</p>";
}

$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT d.*, l.rol FROM users_data d JOIN users_login l ON d.idUser = l.idUser WHERE d.idUser='$id'"));
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="../css/style.css"></head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h2>Editar Usuario</h2>
        <?php echo $msg; ?>
        <form method="POST">
            <label>Nombre:</label> <input type="text" name="nombre" value="<?php echo $u['nombre']; ?>">
            <label>Apellidos:</label> <input type="text" name="apellidos" value="<?php echo $u['apellidos']; ?>">
            <label>Rol:</label>
            <select name="rol">
                <option value="user" <?php if($u['rol']=='user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if($u['rol']=='admin') echo 'selected'; ?>>Admin</option>
            </select>
            <button type="submit" name="actualizar">Guardar Cambios</button>
            <a href="usuarios-administracion.php">Volver</a>
        </form>
    </div>
</body>
</html>