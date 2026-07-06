<?php 
include 'config/conexion.php'; 
if(!isset($_SESSION['idUser'])) header("Location: login.php");

$id = $_SESSION['idUser'];
$mensaje = "";

// Lógica de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = mysqli_real_escape_string($conn, $_POST['nombre']);
    $ape = mysqli_real_escape_string($conn, $_POST['apellidos']);
    $tel = mysqli_real_escape_string($conn, $_POST['telefono']);
    
    // Actualizar datos básicos
    $sql_u = "UPDATE users_data SET nombre='$nom', apellidos='$ape', telefono='$tel' WHERE idUser='$id'";
    
    if(mysqli_query($conn, $sql_u)) {
        $mensaje = "<p class='success'>Datos actualizados correctamente.</p>";
        $_SESSION['nombre'] = $nom; // Actualizar el nombre en la sesión
    }

    // Si el usuario escribió una nueva contraseña
    if(!empty($_POST['new_pass'])) {
        $pass_hash = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users_login SET password='$pass_hash' WHERE idUser='$id'");
        $mensaje .= "<p class='success'>La contraseña también ha sido actualizada.</p>";
    }
}

// Obtener datos actuales para mostrar en el formulario
$res = mysqli_query($conn, "SELECT * FROM users_data WHERE idUser='$id'");
$u = mysqli_fetch_assoc($res);
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
        <h2>Mi Perfil</h2>
        <?php echo $mensaje; ?>
        <form method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $u['nombre']; ?>" required>
            
            <label>Apellidos:</label>
            <input type="text" name="apellidos" value="<?php echo $u['apellidos']; ?>" required>
            
            <label>Teléfono:</label>
            <input type="text" name="telefono" value="<?php echo $u['telefono']; ?>" required>
            
            <label>Email (No editable):</label>
            <input type="text" value="<?php echo $u['email']; ?>" disabled>
            
            <hr>
            <label>Nueva Contraseña (dejar en blanco para no cambiar):</label>
            <input type="password" name="new_pass">
            
            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>