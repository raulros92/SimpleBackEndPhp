<?php
// Incluir el controlador
require_once(__DIR__ . "/../controlador/controlador.php");

// Verificar si se ha enviado el formulario para agregar una nueva noticia
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Obtener los datos del formulario
    $id_autor = obtenerIdUsuarioPorEmail($_SESSION['email']); // Obtener ID del autor (usuario actual)
    $titulo = $_POST["titulo"];
    $cuerpo = $_POST["cuerpo"];
    $fecha = date("Y-m-d"); // Obtener fecha actual

    // Agregar la nueva noticia a la base de datos
    agregarNoticia($id_autor, $titulo, $cuerpo, $fecha);

    // Redirigir a la página de inicio después de agregar la noticia
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Noticia</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <header>
        <h1>Ilernoticias</h1>
        <!-- Puedes incluir el botón de logout aquí si es necesario -->
    </header>

    <main>
        <section id="nuevaNoticia">
            <h2>Agregar Nueva Noticia</h2>
            <form action="nuevaNoticia.php" method="post">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
                <label for="cuerpo">Cuerpo:</label>
                <textarea id="cuerpo" name="cuerpo" rows="5" required></textarea>
                <button type="submit" name="submit">Agregar Noticia</button>
            </form>
        </section>
    </main>

</body>

</html>