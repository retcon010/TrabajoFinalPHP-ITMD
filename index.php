<?php include 'config/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>ITMD | Innovación y Tecnología</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container">
        <!-- SECCIÓN 1: HERO -->
        <header class="hero-section">
            <h1 class="hero-title">Impulsando el <br><span class="text-gradient">Futuro Digital</span></h1>
            <p style="color: var(--text-secondary); max-width: 650px; margin: 0 auto 40px; font-size: 1.2rem;">
                Experimenta la plataforma de gestión más avanzada. Seguridad, rapidez y un diseño Premium pensado para el mañana.
            </p>
            <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                <a href="registro.php" class="btn" style="width: auto; border-radius: 50px;">Empezar Ahora</a>
                <a href="#servicios" class="btn" style="width: auto; background: rgba(255,255,255,0.05); border: 1px solid var(--border); border-radius: 50px;">Ver Servicios</a>
            </div>
        </header>

        <!-- SECCIÓN 2: ESTADÍSTICAS -->
        <section class="stats-grid">
            <div class="stat-card">
                <span class="stat-number">+500</span>
                <p style="color: var(--accent); font-weight: 700;">USUARIOS</p>
            </div>
            <div class="stat-card">
                <span class="stat-number">100%</span>
                <p style="color: var(--accent); font-weight: 700;">SEGURO</p>
            </div>
            <div class="stat-card">
                <span class="stat-number">24/7</span>
                <p style="color: var(--accent); font-weight: 700;">SOPORTE</p>
            </div>
        </section>

        <!-- SECCIÓN 3: SOLUCIONES (GRID) -->
        <section id="servicios">
            <h2 style="text-align: center; margin-bottom: 20px;">Nuestras Soluciones</h2>
            <div class="news-grid">
                <div class="news-card">
                    <div class="news-content">
                        <span class="service-icon">📡</span>
                        <h3>Noticias ITMD</h3>
                        <p>Artículos técnicos de vanguardia y actualizaciones constantes del sector.</p>
                        <a href="noticias.php">Explorar &rarr;</a>
                    </div>
                </div>
                <div class="news-card">
                    <div class="news-content">
                        <span class="service-icon">📅</span>
                        <h3>Citas Online</h3>
                        <p>Gestiona tu tiempo con nuestro sistema de agendamiento inteligente y autónomo.</p>
                        <a href="login.php">Reservar &rarr;</a>
                    </div>
                </div>
                <div class="news-card">
                    <div class="news-content">
                        <span class="service-icon">🔐</span>
                        <h3>Protección</h3>
                        <p>Encriptación de datos personales bajo los más altos estándares internacionales.</p>
                        <a href="registro.php">Seguridad &rarr;</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECCIÓN 4: INFO LATERAL -->
        <section class="info-section">
            <div class="info-image-wrapper">
                <img src="img/pexels-thirdman-7652387.jpg" alt="Tecnología" class="info-image">
            </div>
            <div class="info-content">
                <h2>Liderando el cambio tecnológico</h2>
                <p style="color: var(--text-secondary); margin-bottom: 25px;">
                    En ITMD no solo construimos software, creamos experiencias digitales seguras e intuitivas.
                </p>
                <ul style="list-style: none; color: var(--text-secondary); padding: 0;">
                    <li style="margin-bottom: 12px;"><span style="color: var(--accent);">✦</span> Interfaz de alto contraste.</li>
                    <li style="margin-bottom: 12px;"><span style="color: var(--accent);">✦</span> Gestión centralizada.</li>
                </ul>
            </div>
        </section>

        <!-- SECCIÓN 5: CTA -->
        <section class="cta-banner">
            <h2>¿Listo para empezar?</h2>
            <p>Únete a cientos de usuarios y gestiona tu información hoy mismo.</p>
            <a href="registro.php" class="btn-white">Crear cuenta gratuita</a>
        </section>

        <footer style="padding: 40px 0; border-top: 1px solid var(--border); text-align: center;">
            <p style="color: var(--text-muted); font-size: 0.8rem;">&copy; 2026 ITMD Portal Tecnológico.</p>
        </footer>
    </div>
</body>
</html>