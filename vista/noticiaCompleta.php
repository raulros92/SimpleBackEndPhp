<?php
// Incluir el controlador
require_once("../controlador/controlador.php");

// Verificar si se ha proporcionado un ID de noticia en la URL
if (isset($_GET['id'])) {
    // Obtener el ID de la noticia desde la URL
    $id_noticia = $_GET['id'];

    // Obtener la información completa de la noticia con el ID proporcionado
    $noticia = obtenerNoticiaPorId($id_noticia);

    // Verificar si se encontró la noticia
    if ($noticia) {
        $titulo = $noticia['titulo'];
        $cuerpo = $noticia['cuerpo'];
        $fecha = $noticia['fecha'];
        $autor = $noticia['autor'];
    } else {
        // Si no se encontró la noticia, redirigir a una página de error o mostrar un mensaje de error
        echo "La noticia no existe.";
        exit();
    }
} else {
    // Si no se proporcionó un ID de noticia, redirigir a una página de error o mostrar un mensaje de error
    echo "ID de noticia no proporcionado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?> - Noticia Completa</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <header>
        <h1>Ilernoticias</h1>
        <!-- Puedes incluir el botón de logout aquí si es necesario -->
    </header>

    <main>
        <section id="noticiaCompleta">
            <h2><?php echo $titulo; ?></h2>
            <p><?php echo "Fecha: " . $fecha . " - Autor: " . $autor; ?></p>
            <div class="contenido">
                <?php echo $cuerpo; ?>
            </div>
            <a href="../index.php">Volver al listado de noticias</a>
        </section>
    </main>

</body>

</html>