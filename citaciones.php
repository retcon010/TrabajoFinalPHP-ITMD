<?php 
include 'config/conexion.php'; 

// Seguridad: Si no hay sesión, al login
if (!isset($_SESSION['idUser'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['idUser'];
$msg = "";

// LÓGICA AGREGAR CITA
if (isset($_POST['add'])) {
    $fecha = $_POST['fecha'];
    $motivo = mysqli_real_escape_string($conn, $_POST['motivo']);
    mysqli_query($conn, "INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES ('$id', '$fecha', '$motivo')");
    $msg = "<div class='alert alert-success'>Cita agendada con éxito.</div>";
}

// LÓGICA BORRAR CITA (Pág 6 del PDF: Solo si es futura)
if (isset($_GET['del'])) {
    $idC = $_GET['del'];
    $hoy = date('Y-m-d');
    mysqli_query($conn, "DELETE FROM citas WHERE idCita='$idC' AND idUser='$id' AND fecha_cita > '$hoy'");
    $msg = "<div class='alert alert-success'>Cita cancelada correctamente.</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Mis Citaciones - ITMD</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container">
        <h1>Gestión de Citas</h1>
        <p style="color: var(--text-secondary); margin-bottom: 30px;">Solicita y administra tus citas personales.</p>
        
        <?php echo $msg; ?>

        <!-- FORMULARIO -->
        <div class="form-card" style="margin-bottom: 50px; max-width: 500px;">
            <h3 style="text-align: center; margin-bottom: 25px; color: var(--accent);">Agendar Nueva Cita</h3>
            <form method="POST">
                <div class="input-group">
                    <label>Fecha de la cita</label>
                    <input type="date" name="fecha" min="<?= date('Y-m-d') ?>" required>
                </div>
                
                <div class="input-group">
                    <label>Motivo o Asunto</label>
                    <input type="text" name="motivo" placeholder="Ej: Mantenimiento Preventivo" required>
                </div>
                
                <div style="text-align: center; margin-top: 15px;">
                    <button type="submit" name="add" style="width: auto; padding: 12px 40px; background: var(--accent); border-radius: 30px;">
                        Confirmar Cita
                    </button>
                </div>
            </form>
        </div>

        <!-- TABLA DE CITAS -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Motivo</th>
                        <th>Estado / Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $res = mysqli_query($conn, "SELECT * FROM citas WHERE idUser='$id' ORDER BY fecha_cita ASC");
                    if (mysqli_num_rows($res) > 0) {
                        while($r = mysqli_fetch_assoc($res)) {
                            $es_futura = ($r['fecha_cita'] > date('Y-m-d'));
                            echo "<tr>
                                    <td><strong>".date('d/m/Y', strtotime($r['fecha_cita']))."</strong></td>
                                    <td>{$r['motivo_cita']}</td>
                                    <td>";
                            if($es_futura) {
                                echo "<span style='color: var(--success); margin-right: 15px;'>Pendiente</span>";
                                echo "<a href='?del={$r['idCita']}' style='color: var(--error); font-size: 0.8rem; text-decoration: underline;'>Cancelar</a>";
                            } else {
                                echo "<span style='color: var(--text-muted);'>Realizada</span>";
                            }
                            echo "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' style='text-align:center; padding: 40px; color: var(--text-secondary);'>No tienes citas registradas.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>