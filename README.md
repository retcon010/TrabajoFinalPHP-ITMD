# 🚀 Sistema ITMD - Portal de Gestión Web

Aplicación web desarrollada en **PHP y MySQL** para la gestión de usuarios, citas y noticias, equipada con un panel de administración con control de accesos por roles (**Admin / User**).

🔗 **[Live Demo — Explora el Portal](https://itmd.freedev.app/)**
---

## 📦 Tecnologías

- `PHP 8.2` (Lógica de servidor y Sesiones)
- `MySQL` (Gestión de Base de Datos Relacional)
- `HTML5` (Estructura Semántica Avanzada)
- `CSS3` (Glassmorphism, CSS Grid, Flexbox)
- `JavaScript` (Validaciones Dinámicas y UX)

---

## 🌐 Despliegue
* **Proveedor:** InfinityFree
* **Panel de administración:** https://client.infinityfree.com/

---

## 🛠️ Requisitos del Sistema

* **Servidor Web:** XAMPP (Apache + MySQL)
* **PHP:** Versión 8.0 o superior
* **Navegador Web:** Google Chrome, Mozilla Firefox, Microsoft Edge o Safari

---

## 📦 Instalación y Despliegue Local

### 1. Ubicación de Archivos

Copia la carpeta del proyecto en la ruta de publicación de XAMPP:

```text
C:\xampp\htdocs\sistema_itmd\
```

> **Nota:** Asegúrate de que la carpeta `img/` existe en la raíz del proyecto para permitir la subida de imágenes de noticias.

### 2. Importación de la Base de Datos

1. Inicia los módulos **Apache** y **MySQL** desde el Panel de Control de XAMPP.
2. Abre tu navegador e ingresa a phpMyAdmin: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
3. Crea una nueva base de datos llamada `sistema_itmd` con cotejamiento `utf8mb4_general_ci`.
4. Selecciona `sistema_itmd`, dirígete a la pestaña **Importar**, adjunta el archivo `database.sql` de la raíz del proyecto y pulsa **Ejecutar**.

---

## 🔑 Credenciales de Acceso

Para evaluar el sistema, utiliza el siguiente usuario administrador preconfigurado:

| Rol | Usuario | Contraseña | Ruta de Acceso |
| :--- | :--- | :--- | :--- |
| **Administrador** | `admin` | `admin123` | [http://localhost/sistema_itmd/login.php](http://localhost/sistema_itmd/login.php) |

> 🔒 **Autenticación Híbrida con Auto-Hash:** El sistema cuenta con un motor de autenticación inteligente. Al iniciar sesión por primera vez tras la importación de la base de datos, el sistema valida las credenciales de origen y encripta automáticamente la contraseña en segundo plano usando un hash seguro de Bcrypt adaptado a la versión exacta de PHP de tu servidor.

---

## 📁 Estructura del Proyecto

```plaintext
sistema_itmd/
├── config/
│   └── conexion.php               # Conexión a la BD y gestión de sesión
├── css/
│   └── style.css                  # Hojas de estilo generales (Tema Oscuro)
├── img/                           # Almacenamiento de imágenes subidas
├── includes/
│   └── navbar.php                 # Menú de navegación dinámico por rol
├── admin/
│   ├── usuarios-administracion.php # Panel de gestión de usuarios
│   ├── editar-usuario.php          # Edición completa de usuarios
│   ├── noticias-administracion.php # Publicación y subida de noticias
│   └── citas-administracion.php    # Administración global de citas
├── login.php                      # Autenticación con Auto-Hash
├── perfil.php                     # Gestión de perfil propio
├── database.sql                   # Script de creación e importación de la BD
└── README.md                      # Documentación del proyecto
```