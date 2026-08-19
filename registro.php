<?php 
include 'config/conexion.php'; 

if (isset($_SESSION['idUser'])) {
    header("Location: index.php");
    exit();
}

$msg = "";
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $n = trim($_POST['nombre']);
    $a = trim($_POST['apellidos']);
    $e = trim($_POST['email']);
    $t = trim($_POST['telefono']);
    $dir = trim($_POST['direccion']);
    $sex = $_POST['sexo'];
    $u = trim($_POST['usuario']);
    $p = $_POST['password'];

    // RECONSTRUCCIÓN DE LA FECHA DESDE DESPLEGABLES
    $dia = $_POST['birth_day'];
    $mes = $_POST['birth_month'];
    $anio = $_POST['birth_year'];
    $f = "$anio-$mes-$dia"; // Formato MySQL: YYYY-MM-DD

    // 1. VALIDACIONES PHP EXIGIDAS
    if (empty($n) || empty($e) || empty($u) || empty($p) || $dia=="" || $mes=="" || $anio=="") {
        $msg = "Por favor, rellena todos los campos obligatorios (*).";
        $error = true;
    } 
    // Validar que la fecha sea real (ej: evitar 31 de febrero)
    elseif (!checkdate((int)$mes, (int)$dia, (int)$anio)) {
        $msg = "La fecha de nacimiento introducida no es válida.";
        $error = true;
    }
    elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $n)) {
        $msg = "El nombre solo puede contener letras.";
        $error = true;
    }
    elseif (!ctype_digit($t)) {
        $msg = "El teléfono debe contener solo números.";
        $error = true;
    }
    elseif (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
        $msg = "Email inválido.";
        $error = true;
    }

    // 2. INSERCIÓN
    if (!$error) {
        $p_hash = password_hash($p, PASSWORD_DEFAULT);
        try {
            $q1 = "INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) 
                   VALUES ('$n', '$a', '$e', '$t', '$f', '$dir', '$sex')";
            if (mysqli_query($conn, $q1)) {
                $last_id = mysqli_insert_id($conn);
                mysqli_query($conn, "INSERT INTO users_login (idUser, usuario, password, rol) VALUES ('$last_id', '$u', '$p_hash', 'user')");
                $msg = "SUCCESS: Registro exitoso.";
                header("refresh:2;url=login.php");
            }
        } catch (mysqli_sql_exception $ex) { $msg = "Email o usuario ya en uso."; }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Registro - ITMD</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <div class="form-card" style="max-width: 600px; margin: auto;">
            <h1>Crear Cuenta</h1>
            <?php if($msg): ?>
                <div class="alert <?= strpos($msg, 'SUCCESS') !== false ? 'alert-success' : 'alert-error' ?>"><?= str_replace('SUCCESS: ', '', $msg) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="input-group"><label>Nombre (*)</label><input type="text" name="nombre" required></div>
                    <div class="input-group"><label>Apellidos (*)</label><input type="text" name="apellidos" required></div>
                </div>

                <label>Correo Electrónico (*)</label>
                <input type="email" name="email" required>

                <!-- FECHA DE NACIMIENTO DESPLEGABLE -->
                <label>Fecha de Nacimiento (*)</label>
                <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                    <select name="birth_day" style="flex: 1;" required>
                        <option value="">Día</option>
                        <?php for($i=1; $i<=31; $i++) echo "<option value='$i'>$i</option>"; ?>
                    </select>
                    <select name="birth_month" style="flex: 2;" required>
                        <option value="">Mes</option>
                        <?php 
                        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                        foreach($meses as $num => $nombre) { echo "<option value='".($num+1)."'>$nombre</option>"; }
                        ?>
                    </select>
                    <select name="birth_year" style="flex: 1.5;" required>
                        <option value="">Año</option>
                        <?php for($i=date("Y"); $i>=1920; $i--) echo "<option value='$i'>$i</option>"; ?>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="input-group"><label>Teléfono (*)</label><input type="text" name="telefono" required></div>
                    <div class="input-group">
                        <label>Sexo</label>
                        <select name="sexo">
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                </div>

                <label>Dirección</label>
                <input type="text" name="direccion">

                <hr style="border: 0; border-top: 1px solid var(--border); margin: 20px 0;">
                <label>Usuario (*)</label><input type="text" name="usuario" required>
                <label>Contraseña (*)</label><input type="password" name="password" required>
                <button type="submit">Finalizar Registro</button>
            </form>
        </div>
    </div>
</body>
</html>