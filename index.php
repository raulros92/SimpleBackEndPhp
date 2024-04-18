<?php
// Incluir el controlador
require_once(__DIR__ . "/controlador/controlador.php");

// Verificar si se ha enviado el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit_login"])) {
    // Obtener los datos del formulario
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Llamar a la función iniciarSesion del controlador
    iniciarSesion($email, $password);
}

// Verificar si se ha enviado la solicitud de logout
if (isset($_GET['logout'])) {
    // Llamar a la función cerrarSesion del controlador
    cerrarSesion();
}

// Verificar si se ha enviado la solicitud de eliminación de noticia
if (isset($_GET['action']) && $_GET['action'] == 'eliminar' && isset($_GET['id'])) {
    // Verificar si hay una sesión iniciada antes de eliminar la noticia
    if (isset($_SESSION['email'])) {
        // Llamar a la función para eliminar la noticia
        eliminarNoticiaPorId($_GET['id']);
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ilernoticias</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <header>
        <h1>Ilernoticias</h1>
        <?php
        // Mostrar nombre de usuario y botón de logout si hay una sesión iniciada
        if (isset($_SESSION['email'])) {
            echo "<p>Bienvenido, " . $_SESSION['email'] . "</p>";
            echo "<a href='index.php?logout=true'>Logout</a>";
        } else {
            // Mostrar formulario de inicio de sesión si el usuario no está autenticado
            echo "
            <section id='inicioSesion'>
                <h2>Iniciar Sesión</h2>";
            // Mostrar mensaje de error si existe
            if (isset($_SESSION['mensaje_error'])) {
                echo "<p>{$_SESSION['mensaje_error']}</p>";
                unset($_SESSION['mensaje_error']);
            }
            echo "
                <form action='index.php' method='post'>
                    <label for='email'>Email:</label>
                    <input type='email' id='email' name='email' required>
                    <label for='password'>Contraseña:</label>
                    <input type='password' id='password' name='password' required>
                    <button type='submit' name='submit_login'>Iniciar Sesión</button>
                </form>
            </section>";
        }
        ?>
    </header>

    <main>
        <!-- Botón para acceder a la página de registro -->
        <section id="registroUsuario">
            <a href="vista/registro.php">Registrarse</a>
        </section>

        <!-- Listado de noticias -->
        <section id="noticias">
            <h2>Noticias</h2>
            <?php
            // Verificar si hay una sesión iniciada antes de mostrar las noticias
            if (isset($_SESSION['email'])) {
                // Obtener todas las noticias del controlador
                $noticias = obtenerTodasLasNoticias();
                if ($noticias !== null) {
                    foreach ($noticias as $noticia) {
                        echo "<div class='noticia'>";
                        echo "<h3>" . $noticia['titulo'] . "</h3>";
                        echo "<p>" . $noticia['fecha'] . " - " . $noticia['id_autor'] . "</p>";
                        echo "<a href='vista/noticiaCompleta.php?id=" . $noticia['id'] . "'>Ver más</a>";
                        // Mostrar los botones de editar y eliminar solo si el usuario actual es el autor de la noticia
                        if (isset($_SESSION['id_usuario']) && $noticia['id_autor'] == $_SESSION['id_usuario']) {
                            echo "<a href='vista/noticiaCompleta.php?id=" . $noticia['id'] . "&modo=editar'>Editar</a>";
                            echo "<a href='index.php?action=eliminar&id=" . $noticia['id'] . "'>Borrar</a>";
                        }
                        echo "</div>";
                    }
                } else {
                    echo "<p>No hay noticias disponibles.</p>";
                }
                // Mostrar botón de agregar noticia si hay sesión iniciada
                echo "<a href='vista/nuevaNoticia.php'>Agregar Noticia</a>";
            }
            ?>
        </section>
    </main>

</body>

</html>