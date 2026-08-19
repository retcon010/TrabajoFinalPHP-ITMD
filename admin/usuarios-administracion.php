<?php 
include '../config/conexion.php'; 

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php"); exit();
}

$msg = "";

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    if ($id == $_SESSION['idUser']) {
        $msg = "<div class='alert alert-error'>No puedes eliminar tu propia cuenta de administrador.</div>";
    } else {
        try {
            if (mysqli_query($conn, "DELETE FROM users_data WHERE idUser = '$id'")) {
                $msg = "<div class='alert alert-success'>Usuario eliminado.</div>";
            }
        } catch (mysqli_sql_exception $e) {
            $msg = "<div class='alert alert-error'>Error técnico al eliminar: " . $e->getMessage() . "</div>";
        }
    }
}

if (isset($_POST['crear'])) {
    $n = mysqli_real_escape_string($conn, $_POST['nombre']);
    $a = mysqli_real_escape_string($conn, $_POST['apellidos']);
    $e = mysqli_real_escape_string($conn, $_POST['email']); 
    $t = mysqli_real_escape_string($conn, $_POST['tel']);
    $fn = $_POST['fecha_nacimiento'];
    $dir = mysqli_real_escape_string($conn, $_POST['direccion']);
    $sex = $_POST['sexo'];
    $u = mysqli_real_escape_string($conn, $_POST['user']);
    $r = $_POST['rol'];
    $p = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    $q1 = "INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) 
           VALUES ('$n', '$a', '$e', '$t', '$fn', '$dir', '$sex')";
    if (mysqli_query($conn, $q1)) {
        $last_id = mysqli_insert_id($conn);
        mysqli_query($conn, "INSERT INTO users_login (idUser, usuario, password, rol) VALUES ('$last_id', '$u', '$p', '$r')");
        $msg = "<div class='alert alert-success'>Usuario completo creado con éxito.</div>";
    } else {
        $msg = "<div class='alert alert-error'>Error al crear el usuario.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Admin - Usuarios</title>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 class="page-title">Gestión de Usuarios</h1>
        <?= $msg; ?>

        <details>
            <summary>+ Crear Nuevo Usuario / Administrador</summary>
            <form method="POST" style="margin-top:20px;">
                <div class="form-row">
                    <div class="form-group"><label>Nombre (*):</label><input type="text" name="nombre" required></div>
                    <div class="form-group"><label>Apellidos (*):</label><input type="text" name="apellidos" required></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Email (*):</label><input type="email" name="email" required></div>
                    <div class="form-group"><label>Teléfono:</label><input type="text" name="tel"></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Fecha Nacimiento (*):</label><input type="date" name="fecha_nacimiento" required></div>
                    <div class="form-group"><label>Sexo:</label>
                        <select name="sexo">
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>
                <div class="form-group"><label>Dirección:</label><input type="text" name="direccion"></div>
                <div class="form-row">
                    <div class="form-group"><label>Usuario (*):</label><input type="text" name="user" required></div>
                    <div class="form-group"><label>Contraseña (*):</label><input type="password" name="pass" required></div>
                </div>
                <div class="form-group">
                    <label>Rol:</label>
                    <select name="rol">
                        <option value="user">Usuario (User)</option>
                        <option value="admin">Administrador (Admin)</option>
                    </select>
                </div>
                <button type="submit" name="crear">Registrar Usuario</button>
            </form>
        </details>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr><th>Nombre</th><th>Email</th><th>Rol</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                    <?php 
                    $res = mysqli_query($conn, "SELECT d.*, l.rol FROM users_data d JOIN users_login l ON d.idUser = l.idUser");
                    while($u = mysqli_fetch_assoc($res)): 
                        $badgeClass = ($u['rol'] == 'admin') ? 'badge-admin' : 'badge-user';
                    ?>
                        <tr>
                            <td><?= $u['nombre'] . ' ' . $u['apellidos'] ?></td>
                            <td><?= $u['email'] ?></td>
                            <td><span class="badge-role <?= $badgeClass ?>"><?= $u['rol'] ?></span></td>
                            <td>
                                <a href="editar-usuario.php?id=<?= $u['idUser'] ?>" class="link-edit">Editar</a>
                                <a href="?del=<?= $u['idUser'] ?>" class="link-del" onclick="return confirm('¿Seguro?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>