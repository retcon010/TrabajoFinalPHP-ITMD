<?php 
include '../config/conexion.php'; 

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php"); exit();
}

$msg = "";
// Lógica de borrado
if (isset($_GET['del'])) {
    mysqli_query($conn, "DELETE FROM noticias WHERE idNoticia = '{$_GET['del']}'");
}

// Lógica de creación / modificación
if (isset($_POST['guardar'])) {
    $t = mysqli_real_escape_string($conn, $_POST['titulo']);
    $txt = mysqli_real_escape_string($conn, $_POST['texto']);
    $img = mysqli_real_escape_string($conn, $_POST['imagen_url']);
    $uid = $_SESSION['idUser'];
    $f = date('Y-m-d');

    if (!empty($_POST['idEdit'])) {
        mysqli_query($conn, "UPDATE noticias SET titulo='$t', texto='$txt', imagen='$img' WHERE idNoticia='{$_POST['idEdit']}'");
    } else {
        mysqli_query($conn, "INSERT INTO noticias (titulo, imagen, texto, fecha, idUser) VALUES ('$t', '$img', '$txt', '$f', '$uid')");
    }
}

$noticia_edit = null;
if (isset($_GET['edit'])) {
    $noticia_edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM noticias WHERE idNoticia='{$_GET['edit']}'"));
}
?>
<!DOCTYPE html>
<html lang="es">
<head><link rel="stylesheet" href="../css/style.css"></head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1>Administración de Noticias</h1>

        <div class="form-card">
            <h3><?= $noticia_edit ? "Editar Noticia" : "Crear Noticia" ?></h3>
            <form method="POST">
                <?php if($noticia_edit): ?> <input type="hidden" name="idEdit" value="<?= $noticia_edit['idNoticia'] ?>"> <?php endif; ?>
                <label>Título:</label>
                <input type="text" name="titulo" value="<?= $noticia_edit['titulo'] ?? '' ?>" required>
                <label>Nombre de imagen:</label>
                <input type="text" name="imagen_url" value="<?= $noticia_edit['imagen'] ?? '' ?>" placeholder="ej: noticia.jpg">
                <label>Contenido:</label>
                <textarea name="texto" rows="5" required><?= $noticia_edit['texto'] ?? '' ?></textarea>
                <button type="submit" name="guardar"><?= $noticia_edit ? "Actualizar Noticia" : "Publicar Noticia" ?></button>
            </form>
        </div>

        <div class="table-wrapper">
            <table>
                <thead><tr><th>Título</th><th>Fecha</th><th>Acciones</th></tr></thead>
                <tbody>
                    <?php 
                    $res = mysqli_query($conn, "SELECT * FROM noticias ORDER BY fecha DESC");
                    while($r = mysqli_fetch_assoc($res)) {
                        echo "<tr>
                            <td>{$r['titulo']}</td>
                            <td>{$r['fecha']}</td>
                            <td>
                                <a href='?edit={$r['idNoticia']}' class='link-edit'>Editar</a>
                                <a href='?del={$r['idNoticia']}' class='link-del' onclick='return confirm(\"¿Borrar?\")'>Eliminar</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>