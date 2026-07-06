# 🏢 ITMD Portal — Premium Management Platform

Una plataforma web corporativa, moderna y desarrollada para la gestión integral de servicios, usuarios y noticias. El sistema implementa una arquitectura **Full-Stack** con un enfoque en la seguridad, la integridad de los datos y una experiencia de usuario (UX) de vanguardia basada en una estética **Premium Dark Mode**.

Este proyecto fue desarrollado para dominar la lógica de servidor con PHP, el diseño de bases de datos relacionales con MySQL y la maquetación avanzada con CSS3.

🔗 **[Live Demo — Explora el Portal](https://itmd.freedev.app/)**

---

## 📦 Tecnologías

- `PHP 8.2` (Lógica de servidor y Sesiones)
- `MySQL` (Gestión de Base de Datos Relacional)
- `HTML5` (Estructura Semántica Avanzada)
- `CSS3` (Glassmorphism, CSS Grid, Flexbox)
- `Docker` (Arquitectura de Contenedores para Despliegue)
- `JavaScript` (Validaciones Dinámicas y UX)

## 🦄 Características principales

El portal ITMD ofrece un ecosistema completo para tres niveles de acceso:

- **Arquitectura de Seguridad Avanzada**: Implementación de encriptación de grado industrial mediante `password_hash` (BCrypt) y protección contra inyecciones SQL para garantizar la integridad de la información.
- **Panel de Administración Centralizado**: Interfaz exclusiva para administradores que permite el control total (CRUD) sobre la base de usuarios, el historial de citas y el módulo de noticias corporativas.
- **Gestión Autónoma de Citas**: Sistema inteligente para usuarios registrados que permite solicitar, modificar y cancelar citas en tiempo real, con validación lógica de fechas futuras.
- **Navegación Dinámica RBA**: Barra de navegación inteligente que detecta el rol del usuario (Visitante, User, Admin) y adapta las secciones visibles dinámicamente mediante lógica de sesión.
- **Módulo de Noticias dinámico**: Un feed de artículos técnicos vinculados a autores reales de la base de datos, optimizado con un diseño de "Cards" modernas y responsivas.

### 🎨 Identidad Visual (Premium Dark)
La identidad visual del proyecto está centralizada en tokens globales. Modificar las variables en `style.css` permite actualizar instantáneamente la atmósfera de la plataforma:

```css
:root {
  --bg-main: #050505;      /* Fondo negro profundo para máxima elegancia */
  --accent: #7c3aed;       /* Violeta eléctrico para acentos y estados activos */
  --bg-surface: #111113;   /* Superficies de tarjetas y contenedores */
  --text-primary: #FFFFFF; /* Tipografía clara para alto contraste */
  --border: rgba(255,255,255,0.1); /* Bordes sutiles para definición de UI */
}

## 🛠️ Instalación y Despliegue

- Clona el repositorio: git clone https://github.com/tu-usuario/TrabajoFinalPHP.git
- Importa el archivo database.sql en tu servidor MySQL.
- Configura las credenciales en config/conexion.php.
(Opcional) Si usas Docker, ejecuta: docker-compose up -d --build.