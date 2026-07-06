<?php
$current_page = basename($_SERVER['PHP_SELF']);
$rol = $_SESSION['rol'] ?? 'visitante';
$base_path = ($rol == 'admin' && strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? "../" : "";
$admin_folder = ($rol == 'admin' && strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? "" : "admin/";
?>
<nav>
    <a href="<?= $base_path ?>index.php" <?= $current_page == 'index.php' ? 'class="active"' : '' ?>>Inicio</a>
    <a href="<?= $base_path ?>noticias.php" <?= $current_page == 'noticias.php' ? 'class="active"' : '' ?>>Noticias</a>

    <?php if($rol == 'visitante'): ?>
        <a href="<?= $base_path ?>registro.php" <?= $current_page == 'registro.php' ? 'class="active"' : '' ?>>Registro</a>
        <a href="<?= $base_path ?>login.php" <?= $current_page == 'login.php' ? 'class="active"' : '' ?>>Login</a>
    <?php elseif($rol == 'user'): ?>
        <a href="<?= $base_path ?>citaciones.php" <?= $current_page == 'citaciones.php' ? 'class="active"' : '' ?>>Mis Citas</a>
        <a href="<?= $base_path ?>perfil.php" <?= $current_page == 'perfil.php' ? 'class="active"' : '' ?>>Perfil</a>
    <?php elseif($rol == 'admin'): ?>
        <a href="<?= $admin_folder ?>usuarios-administracion.php" <?= $current_page == 'usuarios-administracion.php' ? 'class="active"' : '' ?>>Usuarios</a>
        <a href="<?= $admin_folder ?>citas-administracion.php" <?= $current_page == 'citas-administracion.php' ? 'class="active"' : '' ?>>Citas Admin</a>
        <a href="<?= $admin_folder ?>noticias-administracion.php" <?= $current_page == 'noticias-administracion.php' ? 'class="active"' : '' ?>>Noticias Admin</a>
        <a href="<?= $base_path ?>perfil.php" <?= $current_page == 'perfil.php' ? 'class="active"' : '' ?>>Perfil</a>
    <?php endif; ?>

    <?php if($rol != 'visitante'): ?>
        <a href="<?= $base_path ?>logout.php" style="color: #ef4444;">Salir</a>
    <?php endif; ?>
</nav>