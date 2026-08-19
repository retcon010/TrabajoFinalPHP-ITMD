<?php 
include 'config/conexion.php'; 
if (!isset($_SESSION['idUser'])) { header("Location: login.php"); exit(); }
$id = $_SESSION['idUser'];
$msg = "";

// 1. LÓGICA PARA BORRAR
if (isset($_GET['del'])) {
    $idC = $_GET['del'];
    $hoy = date('Y-m-d');
    mysqli_query($conn, "DELETE FROM citas WHERE idCita='$idC' AND idUser='$id' AND fecha_cita > '$hoy'");
    $msg = "<div class='alert alert-success'>Cita eliminada correctamente.</div>";
}

// 2. LÓGICA PARA ACTUALIZAR O INSERTAR
if (isset($_POST['procesar'])) {
    $d = $_POST['day']; $m = $_POST['month']; $a = $_POST['year'];
    $motivo = mysqli_real_escape_string($conn, $_POST['motivo']);
    $fecha_final = "$a-$m-$d";

    if (!checkdate((int)$m, (int)$d, (int)$a)) {
        $msg = "<div class='alert alert-error'>La fecha seleccionada no es válida.</div>";
    } else {
        if (!empty($_POST['idCita_edit'])) {
            $idEdit = $_POST['idCita_edit'];
            mysqli_query($conn, "UPDATE citas SET fecha_cita='$fecha_final', motivo_cita='$motivo' WHERE idCita='$idEdit' AND idUser='$id'");
            $msg = "<div class='alert alert-success'>Cita actualizada.</div>";
        } else {
            mysqli_query($conn, "INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES ('$id', '$fecha_final', '$motivo')");
            $msg = "<div class='alert alert-success'>Cita agendada con éxito.</div>";
        }
    }
}

// 3. RECUPERAR DATOS PARA EDITAR
$edit_data = null;
if (isset($_GET['edit'])) {
    $res = mysqli_query($conn, "SELECT * FROM citas WHERE idCita='{$_GET['edit']}' AND idUser='$id'");
    $edit_data = mysqli_fetch_assoc($res);
    if($edit_data) {
        $fecha_parts = explode("-", $edit_data['fecha_cita']);
        $e_year = $fecha_parts[0]; $e_month = (int)$fecha_parts[1]; $e_day = (int)$fecha_parts[2];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><link rel="stylesheet" href="css/style.css"></head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <h1>Mis Citas</h1>
        <?php echo $msg; ?>

        <div class="form-card" style="max-width: 500px; margin: 0 auto 50px auto;">
            <h3><?= $edit_data ? "Modificar Cita" : "Nueva Cita" ?></h3>
            <form method="POST">
                <?php if($edit_data): ?> <input type="hidden" name="idCita_edit" value="<?= $edit_data['idCita'] ?>"> <?php endif; ?>
                
                <label>Fecha Seleccionada:</label>
                <div style="display: flex; gap: 5px;">
                    <select name="day" required>
                        <?php for($i=1;$i<=31;$i++) { $s = (isset($e_day) && $e_day==$i) ? "selected" : ""; echo "<option value='$i' $s>$i</option>"; } ?>
                    </select>
                    <select name="month" required>
                        <?php $meses=["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"]; 
                        foreach($meses as $k=>$v) { $s=(isset($e_month) && $e_month==($k+1))?"selected":""; echo "<option value='".($k+1)."' $s>$v</option>"; } ?>
                    </select>
                    <select name="year" required>
                        <?php for($i=date("Y");$i<=date("Y")+2;$i++) { $s=(isset($e_year) && $e_year==$i)?"selected":""; echo "<option value='$i' $s>$i</option>"; } ?>
                    </select>
                </div>
                
                <div style="margin-bottom: 24px;">
                    <label>Motivo:</label>
                    <input type="text" name="motivo" value="<?= $edit_data['motivo_cita'] ?? '' ?>" required>
                </div>
                <button type="submit" name="procesar" class="btn-primary" style="width: 100%;"><?= $edit_data ? "Guardar Cambios" : "Agendar" ?></button>
                <?php if($edit_data): ?> <a href="citaciones.php" style="display:block; text-align:center; margin-top:10px;">Cancelar</a> <?php endif; ?>
            </form>
        </div>

        <div class="table-wrapper">
            <table>
                <thead><tr><th>Fecha</th><th>Motivo</th><th>Acciones</th></tr></thead>
                <tbody>
                    <?php 
                    $res = mysqli_query($conn, "SELECT * FROM citas WHERE idUser='$id' ORDER BY fecha_cita ASC");
                    while($r = mysqli_fetch_assoc($res)) {
                        echo "<tr><td>".date('d/m/Y', strtotime($r['fecha_cita']))."</td><td>{$r['motivo_cita']}</td><td>
                        <div style='display: flex; gap: 15px; align-items: center;'>
                            <a href='?edit={$r['idCita']}' class='link-edit' style='margin: 0;'>Editar</a>
                            <a href='?del={$r['idCita']}' class='link-del'>Eliminar</a>
                        </div>
                        </td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>