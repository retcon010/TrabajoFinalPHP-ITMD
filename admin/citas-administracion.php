<?php 
include '../config/conexion.php'; 

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') { header("Location: ../login.php"); exit(); }
$msg = "";

// LÓGICA DE BORRADO (CORREGIDO: Ya no restringe solo por idUser)
if (isset($_GET['del'])) {
    $idDel = mysqli_real_escape_string($conn, $_GET['del']);
    if (mysqli_query($conn, "DELETE FROM citas WHERE idCita='$idDel'")) {
        $msg = "<div class='alert alert-success'>Cita eliminada correctamente.</div>";
    } else {
        $msg = "<div class='alert alert-error'>Error al eliminar la cita.</div>";
    }
}

// LÓGICA DE GUARDADO / EDICIÓN
if (isset($_POST['guardar_cita'])) {
    $dia = $_POST['day'];
    $mes = $_POST['month'];
    $anio = $_POST['year'];
    $motivo = mysqli_real_escape_string($conn, $_POST['motivo']);
    $fecha_formateada = "$anio-$mes-$dia";

    if (!checkdate((int)$mes, (int)$dia, (int)$anio)) {
        $msg = "<div class='alert alert-error'>La fecha elegida no existe.</div>";
    } else {
        if (!empty($_POST['idCita_edit'])) {
            $idCita = $_POST['idCita_edit'];
            mysqli_query($conn, "UPDATE citas SET fecha_cita='$fecha_formateada', motivo_cita='$motivo' WHERE idCita='$idCita'");
            $msg = "<div class='alert alert-success'>Cita modificada correctamente.</div>";
        } else {
            $idUsuario = $_SESSION['idUser'];
            mysqli_query($conn, "INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES ('$idUsuario', '$fecha_formateada', '$motivo')");
            $msg = "<div class='alert alert-success'>Nueva cita agendada.</div>";
        }
    }
}

$cita_editando = null;
if (isset($_GET['edit'])) {
    $idEdit = mysqli_real_escape_string($conn, $_GET['edit']);
    $res = mysqli_query($conn, "SELECT * FROM citas WHERE idCita='$idEdit'");
    $cita_editando = mysqli_fetch_assoc($res);
    if ($cita_editando) {
        $partes = explode("-", $cita_editando['fecha_cita']);
        $selAnio = $partes[0];
        $selMes  = (int)$partes[1];
        $selDia  = (int)$partes[2];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Admin - Citas</title>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 class="page-title">Gestión de Citas</h1>
        <?= $msg; ?>

        <div class="form-card" style="max-width: 500px;">
            <h2><?= $cita_editando ? "Editar Cita" : "Nueva Cita" ?></h2>
            <!-- CORREGIDO: Redirección al mismo archivo -->
            <form method="POST" action="citas-administracion.php">
                <?php if($cita_editando): ?>
                    <input type="hidden" name="idCita_edit" value="<?= $cita_editando['idCita'] ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Fecha:</label>
                    <div class="date-selector">
                        <select name="day" required>
                            <?php for($i=1; $i<=31; $i++) {
                                $selected = (isset($selDia) && $selDia == $i) ? "selected" : "";
                                echo "<option value='$i' $selected>$i</option>";
                            } ?>
                        </select>
                        <select name="month" required>
                            <?php 
                            $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                            foreach($meses as $num => $nombre) {
                                $mVal = $num + 1;
                                $selected = (isset($selMes) && $selMes == $mVal) ? "selected" : "";
                                echo "<option value='$mVal' $selected>$nombre</option>";
                            } ?>
                        </select>
                        <select name="year" required>
                            <?php for($i=2024; $i<=2028; $i++) {
                                $selected = (isset($selAnio) && $selAnio == $i) ? "selected" : "";
                                echo "<option value='$i' $selected>$i</option>";
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Motivo:</label>
                    <input type="text" name="motivo" value="<?= $cita_editando['motivo_cita'] ?? '' ?>" required>
                </div>

                <button type="submit" name="guardar_cita">
                    <?= $cita_editando ? "Guardar Cambios" : "Agendar Cita" ?>
                </button>

                <?php if($cita_editando): ?>
                    <div style="text-align: center; margin-top: 15px;">
                        <a href="citas-administracion.php" class="link-cancel">Cancelar edición</a>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr><th>Usuario</th><th>Fecha</th><th>Motivo</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                    <?php 
                    $res = mysqli_query($conn, "SELECT c.*, d.nombre, d.apellidos FROM citas c JOIN users_data d ON c.idUser = d.idUser ORDER BY c.fecha_cita ASC");
                    while($r = mysqli_fetch_assoc($res)) {
                        echo "<tr>
                                <td>{$r['nombre']} {$r['apellidos']}</td>
                                <td>".date('d/m/Y', strtotime($r['fecha_cita']))."</td>
                                <td>{$r['motivo_cita']}</td>
                                <td>
                                    <a href='?edit={$r['idCita']}' class='link-edit'>Editar</a>
                                    <a href='?del={$r['idCita']}' class='link-del' onclick='return confirm(\"¿Borrar cita?\")'>Eliminar</a>
                                </td>
                              </tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>