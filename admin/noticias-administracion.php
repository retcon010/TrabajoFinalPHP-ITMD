<?php 
include '../config/conexion.php'; 

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php"); exit();
}

$msg = "";

if (isset($_GET['del'])) {
    $idDel = mysqli_real_escape_string($conn, $_GET['del']);
    mysqli_query($conn, "DELETE FROM noticias WHERE idNoticia = '$idDel'");
    $msg = "<div class='alert alert-success'>Noticia eliminada.</div>";
}

if (isset($_POST['guardar'])) {
    $t = mysqli_real_escape_string($conn, $_POST['titulo']);
    $txt = mysqli_real_escape_string($conn, $_POST['texto']);
    $uid = $_SESSION['idUser'];
    $f = date('Y-m-d');
    $img_nombre = $_POST['imagen_actual'] ?? '';

    // PROCESAMIENTO DE LA IMAGEN SUBIDA
    if (isset($_FILES['imagen_file']) && $_FILES['imagen_file']['error'] == 0) {
        $nombre_original = basename($_FILES['imagen_file']['name']);
        $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
        $nuevo_nombre = time() . '_' . uniqid() . '.' . $extension;
        $destino = "../img/" . $nuevo_nombre;

        if (move_uploaded_file($_FILES['imagen_file']['tmp_name'], $destino)) {
            $img_nombre = $nuevo_nombre;
        } else {
            $msg = "<div class='alert alert-error'>Error al mover la imagen guardada.</div>";
        }
    }

    if (!empty($_POST['idEdit'])) {
        $idEdit = $_POST['idEdit'];
        mysqli_query($conn, "UPDATE noticias SET titulo='$t', texto='$txt', imagen='$img_nombre' WHERE idNoticia='$idEdit'");
        $msg = "<div class='alert alert-success'>Noticia actualizada correctamente.</div>";
    } else {
        mysqli_query($conn, "INSERT INTO noticias (titulo, imagen, texto, fecha, idUser) VALUES ('$t', '$img_nombre', '$txt', '$f', '$uid')");
        $msg = "<div class='alert alert-success'>Noticia creada con imagen subida.</div>";
    }
}

$noticia_edit = null;
if (isset($_GET['edit'])) {
    $idEdit = mysqli_real_escape_string($conn, $_GET['edit']);
    $noticia_edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM noticias WHERE idNoticia='$idEdit'"));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Admin - Noticias</title>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 class="page-title">Administración de Noticias</h1>
        <?= $msg; ?>

        <div class="form-card" style="max-width: 650px;">
            <h2><?= $noticia_edit ? "Editar Noticia" : "Crear Noticia" ?></h2>
            <!-- CORREGIDO: Agregado enctype para poder subir archivos -->
            <form method="POST" enctype="multipart/form-data">
                <?php if($noticia_edit): ?> 
                    <input type="hidden" name="idEdit" value="<?= $noticia_edit['idNoticia'] ?>"> 
                    <input type="hidden" name="imagen_actual" value="<?= $noticia_edit['imagen'] ?>"> 
                <?php endif; ?>
                
                <div class="form-group">
                    <label>Título:</label>
                    <input type="text" name="titulo" value="<?= $noticia_edit['titulo'] ?? '' ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Subir Imagen desde el dispositivo:</label>
                    <input type="file" name="imagen_file" accept="image/*" <?= $noticia_edit ? '' : 'required' ?>>
                    <?php if($noticia_edit && !empty($noticia_edit['imagen'])): ?>
                        <small style="color: var(--text-secondary); display:block; margin-top:5px;">Imagen actual: <?= $noticia_edit['imagen'] ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Contenido:</label>
                    <textarea name="texto" rows="5" required><?= $noticia_edit['texto'] ?? '' ?></textarea>
                </div>

                <button type="submit" name="guardar"><?= $noticia_edit ? "Actualizar Noticia" : "Publicar Noticia" ?></button>
                <?php if($noticia_edit): ?>
                    <div style="text-align: center; margin-top: 15px;">
                        <a href="noticias-administracion.php" class="link-cancel">Cancelar edición</a>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr><th>Imagen</th><th>Título</th><th>Fecha</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                    <?php 
                    $res = mysqli_query($conn, "SELECT * FROM noticias ORDER BY fecha DESC");
                    while($r = mysqli_fetch_assoc($res)): ?>
                        <tr>
                            <td>
                                <?php if(!empty($r['imagen'])): ?>
                                    <img src="../img/<?= $r['imagen'] ?>" alt="Img" style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px;">
                                <?php else: ?>
                                    <span>Sin imagen</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $r['titulo'] ?></td>
                            <td><?= date('d/m/Y', strtotime($r['fecha'])) ?></td>
                            <td>
                                <a href="?edit=<?= $r['idNoticia'] ?>" class="link-edit">Editar</a>
                                <a href="?del=<?= $r['idNoticia'] ?>" class="link-del" onclick="return confirm('¿Borrar noticia?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>