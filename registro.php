<?php 
include 'config/conexion.php'; 

// BLOQUEO DE SESIÓN: Si el usuario ya está dentro, no puede registrarse otra vez
if (isset($_SESSION['idUser'])) {
    header("Location: index.php");
    exit();
}

$msg = "";

// 2. PROCESAMIENTO DEL FORMULARIO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $n = mysqli_real_escape_string($conn, $_POST['nombre']);
    $a = mysqli_real_escape_string($conn, $_POST['apellidos']);
    $e = mysqli_real_escape_string($conn, $_POST['email']);
    $t = mysqli_real_escape_string($conn, $_POST['telefono']);
    $f = $_POST['fecha_nacimiento'];
    $dir = mysqli_real_escape_string($conn, $_POST['direccion']);
    $sex = $_POST['sexo'];
    $u = mysqli_real_escape_string($conn, $_POST['usuario']);
    $p = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $q1 = "INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) 
               VALUES ('$n', '$a', '$e', '$t', '$f', '$dir', '$sex')";
        
        if (mysqli_query($conn, $q1)) {
            $last_id = mysqli_insert_id($conn);
            mysqli_query($conn, "INSERT INTO users_login (idUser, usuario, password, rol) 
                                VALUES ('$last_id', '$u', '$p', 'user')");
            
            $msg = "<div class='alert alert-success'>¡Registro exitoso! Redirigiendo al login...</div>";
            header("refresh:2;url=login.php");
        }
    } catch (mysqli_sql_exception $ex) {
        // Capturamos el error si el email o usuario ya existen
        $msg = "<div class='alert alert-error'>Error: El email o el usuario ya están en uso.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Registro Premium - ITMD</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container">
        <div class="form-card" style="max-width: 600px;">
            <h1 style="text-align: center; margin-bottom: 10px;">Crear Cuenta</h1>
            <p style="text-align: center; color: var(--text-secondary); margin-bottom: 30px;">
                Únete a la comunidad de ITMD
            </p>

            <?php echo $msg; ?>

            <form method="POST">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="input-group">
                        <label>Nombre (*)</label>
                        <input type="text" name="nombre" placeholder="Tu nombre" required>
                    </div>
                    <div class="input-group">
                        <label>Apellidos (*)</label>
                        <input type="text" name="apellidos" placeholder="Tus apellidos" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Correo Electrónico (*)</label>
                    <input type="email" name="email" placeholder="correo@ejemplo.com" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="input-group">
                        <label>Teléfono (*)</label>
                        <input type="text" name="telefono" placeholder="Ej: 600123456" required>
                    </div>
                    <div class="input-group">
                        <label>Sexo</label>
                        <select name="sexo">
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>

                <div class="input-group">
                    <label>Fecha de Nacimiento (*)</label>
                    <input type="date" name="fecha_nacimiento" required>
                </div>

                <div class="input-group">
                    <label>Dirección</label>
                    <input type="text" name="direccion" placeholder="Calle, Número, Ciudad">
                </div>

                <div style="border-top: 1px solid var(--border); margin: 20px 0; padding-top: 20px;">
                    <div class="input-group">
                        <label>Nombre de Usuario (*)</label>
                        <input type="text" name="usuario" placeholder="Nombre de usuario único" required>
                    </div>
                    <div class="input-group">
                        <label>Contraseña (*)</label>
                        <input type="password" name="password" placeholder="Mínimo 6 caracteres" required>
                    </div>
                </div>

                <button type="submit" style="margin-top: 10px;">Finalizar Registro</button>
            </form>

            <p style="text-align: center; margin-top: 20px; font-size: 0.9rem; color: var(--text-secondary);">
                ¿Ya eres miembro? <a href="login.php" style="color: var(--accent); font-weight: bold;">Inicia Sesión</a>
            </p>
        </div>
    </div>
</body>
</html>