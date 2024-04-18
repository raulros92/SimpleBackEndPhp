<?php
// Incluir el controlador
require_once(__DIR__ . "/../controlador/controlador.php");

// Verificar si el formulario de registro ha sido enviado
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit_registro"])) {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    // Registrar al usuario
    $registro_exitoso = registrarUsuario($nombre, $email, $contrasena);

    // Si el registro no fue exitoso, mostrar un mensaje de error
    if (!$registro_exitoso) {
        echo "Hubo un error al registrar el usuario. Por favor, inténtelo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <header>
        <h1>Registro de Usuario</h1>
    </header>

    <main>
        <section id="registroUsuario">
            <h2>Registro de Nuevo Usuario</h2>
            <form action="registro.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
                <button type="submit" name="submit_registro">Registrar</button>
            </form>
        </section>
    </main>

</body>

</html>