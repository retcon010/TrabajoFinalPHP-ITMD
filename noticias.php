<?php include 'config/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head><link rel="stylesheet" href="css/style.css"></head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <h1>Últimas Noticias</h1>
        <div class="news-grid">
            <?php
            $sql = "SELECT n.*, d.nombre, d.apellidos FROM noticias n JOIN users_data d ON n.idUser = d.idUser ORDER BY n.fecha DESC";
            $res = mysqli_query($conn, $sql);
            while($r = mysqli_fetch_assoc($res)): ?>
            <div class="news-card">
                <img src="img/<?= $r['imagen'] ?>" alt="News">
                <div class="news-content">
                    <span style="color: var(--accent); font-size: 0.8rem; font-weight: 700;"><?= date("d M, Y", strtotime($r['fecha'])) ?></span>
                    <h3 style="margin-top: 5px;"><?= $r['titulo'] ?></h3>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 15px 0;"><?= substr($r['texto'], 0, 120) ?>...</p>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 0.8rem;">
                        <div style="width: 30px; height: 30px; background: var(--accent); border-radius: 50%;"></div>
                        <span>Por: <?= $r['nombre'] ?> <?= $r['apellidos'] ?></span>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>