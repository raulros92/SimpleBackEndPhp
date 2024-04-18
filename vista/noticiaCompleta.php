<!-- Noticia en detalle -->
<?php
// Incluir el controlador
require_once(__DIR__ . "/../controlador/controlador.php");

// Verificar si se ha proporcionado un ID de noticia en la URL
if (isset($_GET['id'])) {
    // Obtener el ID de la noticia desde la URL
    $id_noticia = $_GET['id'];

    // Verificar si se proporcionó el modo de edición
    $modo_edicion = isset($_GET['modo']) && $_GET['modo'] === 'editar';

    // Si estamos en modo de edición, recuperar la información de la noticia existente
    if ($modo_edicion) {
        // Obtener la información completa de la noticia con el ID proporcionado
        $noticia = obtenerNoticiaPorId($id_noticia);

        // Verificar si se encontró la noticia
        if ($noticia) {
            $titulo = $noticia['titulo'];
            $cuerpo = $noticia['cuerpo'];
            $fecha = $noticia['fecha'];
            $autor = $noticia['id_autor'];
        } else {
            // Si no se encontró la noticia, mostrar un mensaje de error
            echo "La noticia no existe.";
            exit();
        }
    } else {
        // Si no estamos en modo de edición, proceder con la visualización de la noticia
        // Obtener la información completa de la noticia con el ID proporcionado
        $noticia = obtenerNoticiaPorId($id_noticia);

        // Verificar si se encontró la noticia
        if ($noticia) {
            $titulo = $noticia['titulo'];
            $cuerpo = $noticia['cuerpo'];
            $fecha = $noticia['fecha'];
            $autor = $noticia['id_autor'];
        } else {
            // Si no se encontró la noticia, mostrar un mensaje de error
            echo "La noticia no existe.";
            exit();
        }
    }

    // Procesar la actualización de la noticia si se envió el formulario de edición
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit_noticia"])) {
        // Obtener los datos del formulario
        $titulo_actualizado = $_POST["titulo"];
        $cuerpo_actualizado = $_POST["cuerpo"];
        $fecha_actualizada = $_POST["fecha"];

        // Llamar a la función para actualizar la noticia
        editarNoticia($id_noticia, $titulo_actualizado, $cuerpo_actualizado, $fecha_actualizada);

        // Redirigir de vuelta a la página principal
        header("Location: ../index.php");
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
    <title><?php echo $modo_edicion ? 'Editar Noticia' : $titulo . ' - Noticia Completa'; ?></title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <header>
        <h1>Ilernoticias</h1>
        <!-- Puedes incluir el botón de logout aquí si es necesario -->
    </header>

    <main>
        <section id="noticiaCompleta">
            <?php if ($modo_edicion) : ?>
                <!-- Formulario de edición -->
                <h2>Editar Noticia</h2>
                <form action="noticiaCompleta.php?id=<?php echo $id_noticia; ?>&modo=editar" method="post">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>" required>
                    <label for="cuerpo">Cuerpo:</label>
                    <textarea id="cuerpo" name="cuerpo" rows="6" required><?php echo $cuerpo; ?></textarea>
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>" required>
                    <button type="submit" name="submit_noticia">Guardar Cambios</button>
                </form>
            <?php else : ?>
                <!-- Vista de la noticia -->
                <h2><?php echo $titulo; ?></h2>
                <p><?php echo "Fecha: " . $fecha . " - Autor: " . $autor; ?></p>
                <div class="contenido">
                    <?php echo $cuerpo; ?>
                </div>
                <a href="../index.php">Volver al listado de noticias</a>
            <?php endif; ?>
        </section>
    </main>

</body>

</html>