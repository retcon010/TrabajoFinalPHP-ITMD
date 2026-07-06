<?php 
include '../config/conexion.php'; 

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php"); exit();
}

$msg = "";

// LÓGICA PARA BORRAR
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    if ($id != $_SESSION['idUser']) { // No permitirse borrar a uno mismo
        mysqli_query($conn, "DELETE FROM users_data WHERE idUser = '$id'");
        $msg = "<p class='success'>Usuario eliminado correctamente.</p>";
    } else {
        $msg = "<p class='error'>No puedes borrar tu propia cuenta de administrador.</p>";
    }
}

// LÓGICA PARA CREAR NUEVO (REQUISITO PDF)
if (isset($_POST['crear'])) {
    $n = $_POST['nombre']; $a = $_POST['apellidos']; $e = $_POST['email']; 
    $t = $_POST['tel']; $u = $_POST['user']; $r = $_POST['rol'];
    $p = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    $q1 = "INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento) VALUES ('$n', '$a', '$e', '$t', '1990-01-01')";
    if (mysqli_query($conn, $q1)) {
        $last_id = mysqli_insert_id($conn);
        mysqli_query($conn, "INSERT INTO users_login (idUser, usuario, password, rol) VALUES ('$last_id', '$u', '$p', '$r')");
        $msg = "<p class='success'>Usuario creado con éxito.</p>";
    }
}

// LÓGICA PARA BORRAR
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    
    // Verificamos que el admin no se borre a sí mismo
    if ($id == $_SESSION['idUser']) {
        $msg = "<div class='alert alert-error'>No puedes eliminar tu propia cuenta de administrador.</div>";
    } else {
        try {
            $query = "DELETE FROM users_data WHERE idUser = '$id'";
            if (mysqli_query($conn, $query)) {
                $msg = "<div class='alert alert-success'>Usuario y todos sus datos asociados (noticias, citas) eliminados.</div>";
            }
        } catch (mysqli_sql_exception $e) {
            $msg = "<div class='alert alert-error'>Error técnico: " . $e->getMessage() . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
    <title>Admin Usuarios</title>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h2>Panel de Administración: Usuarios</h2>
        <?php echo $msg; ?>

        <!-- FORMULARIO PARA CREAR (Requisito PDF 1.4) -->
        <details style="background: var(--bg-surface); padding: 10px; margin-bottom: 20px; border-radius: 5px;">
            <summary style="cursor:pointer; font-weight:bold;">+ Crear Nuevo Usuario / Administrador</summary>
            <form method="POST" style="margin-top:10px;">
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="text" name="apellidos" placeholder="Apellidos" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="tel" placeholder="Teléfono">
                <input type="text" name="user" placeholder="Usuario" required>
                <input type="password" name="pass" placeholder="Contraseña" required>
                <select name="rol">
                    <option value="user">Usuario (User)</option>
                    <option value="admin">Administrador (Admin)</option>
                </select>
                <button type="submit" name="crear">Registrar Usuario</button>
            </form>
        </details>

        <table>
            <tr style="background:#0056b3; color:white;">
                <th>Nombre</th><th>Email</th><th>Rol</th><th>Acciones</th>
            </tr>
            <?php 
            $res = mysqli_query($conn, "SELECT d.*, l.rol FROM users_data d JOIN users_login l ON d.idUser = l.idUser");
            while($u = mysqli_fetch_assoc($res)) {
                echo "<tr>
                    <td>{$u['nombre']} {$u['apellidos']}</td>
                    <td>{$u['email']}</td>
                    <td><span class='tag'>{$u['rol']}</span></td>
                    <td>
                        <a href='editar-usuario.php?id={$u['idUser']}'>Editar</a> | 
                        <a href='?del={$u['idUser']}' style='color:red;' onclick='return confirm(\"¿Seguro?\")'>Eliminar</a>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>