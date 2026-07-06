<?php 
include '../config/conexion.php'; 

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php"); exit();
}

$user_selected = $_GET['idUser'] ?? null;
$msg = "";

if (isset($_POST['crear'])) {
    $idU = $_POST['idUser_hidden'];
    $fecha = $_POST['fecha'];
    $motivo = mysqli_real_escape_string($conn, $_POST['motivo']);
    mysqli_query($conn, "INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES ('$idU', '$fecha', '$motivo')");
    $msg = "<p style='color:var(--accent)'>Cita creada con éxito.</p>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head><link rel="stylesheet" href="../css/style.css"></head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1>Gestión de Citas Admin</h1>
        
        <div class="form-card">
            <label>Seleccionar Usuario para gestionar:</label>
            <form method="GET" action="citas-administracion.php">
                <select name="idUser" onchange="this.form.submit()">
                    <option value="">-- Elige un usuario registrado --</option>
                    <?php 
                    $res_u = mysqli_query($conn, "SELECT idUser, nombre, apellidos FROM users_data");
                    while($u = mysqli_fetch_assoc($res_u)) {
                        $sel = ($user_selected == $u['idUser']) ? "selected" : "";
                        echo "<option value='{$u['idUser']}' $sel>{$u['nombre']} {$u['apellidos']}</option>";
                    }
                    ?>
                </select>
            </form>
        </div>

        <?php if ($user_selected): ?>
            <div class="form-card">
                <h3>Agendar para este usuario</h3>
                <?php echo $msg; ?>
                <form method="POST">
                    <input type="hidden" name="idUser_hidden" value="<?= $user_selected ?>">
                    <label>Fecha:</label>
                    <input type="date" name="fecha" required>
                    <label>Motivo:</label>
                    <input type="text" name="motivo" placeholder="Motivo de la cita" required>
                    <button type="submit" name="crear">Confirmar Cita</button>
                </form>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead><tr><th>Fecha</th><th>Motivo</th><th>Acción</th></tr></thead>
                    <tbody>
                        <?php 
                        $res_c = mysqli_query($conn, "SELECT * FROM citas WHERE idUser = '$user_selected' ORDER BY fecha_cita DESC");
                        while($c = mysqli_fetch_assoc($res_c)) {
                            echo "<tr>
                                <td>{$c['fecha_cita']}</td>
                                <td>{$c['motivo_cita']}</td>
                                <td><a href='?idUser=$user_selected&del_cita={$c['idCita']}' class='link-del'>Eliminar</a></td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>