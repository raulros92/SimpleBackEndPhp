<!-- Controlador -->
<?php

session_start(); // Iniciar la sesión

require_once(__DIR__ . "/../modelo/database.php");

// Función para verificar las credenciales del usuario
function verificarCredenciales($email, $contrasena)
{
    // Consulta SQL para verificar las credenciales
    $sql = "SELECT * FROM usuario WHERE email='$email' AND contrasena='$contrasena'";

    // Ejecutar la consulta
    $resultado = consultar($sql);

    // Verificar si se encontró algún resultado
    if (mysqli_num_rows($resultado) == 1) {
        // Credenciales válidas
        return true;
    } else {
        // Credenciales inválidas
        return false;
    }
}

// Función para iniciar sesión
function iniciarSesion($email, $contrasena)
{
    // Verificar las credenciales del usuario
    $usuario_valido = verificarCredenciales($email, $contrasena);
    if ($usuario_valido) {
        // Consultar el ID del usuario desde la base de datos
        $sql = "SELECT id FROM usuario WHERE email='$email'";
        $resultado = consultar($sql);
        $fila = mysqli_fetch_assoc($resultado);
        $id_usuario = $fila['id'];

        // Iniciar sesión para el usuario y almacenar su ID
        $_SESSION['email'] = $email;
        $_SESSION['id_usuario'] = $id_usuario;

        // Redirigir a la página de inicio
        header("Location: ../index.php");
        exit();
    } else {
        // Mostrar mensaje de error al usuario
        $_SESSION['mensaje_error'] = "Credenciales incorrectas. Por favor, inténtelo de nuevo.";
        // Permanecer en la página actual
        return false;
    }
}

// Función para cerrar sesión
function cerrarSesion()
{
    // Destruir la sesión
    session_destroy();
    // Redirigir a la página de inicio
    header("Location: ../index.php");
    exit();
}

// Función para registrar un nuevo usuario
function registrarUsuario($nombre, $email, $contrasena)
{
    $sql = "INSERT INTO usuario (nombre, email, contrasena) VALUES ('$nombre', '$email', '$contrasena')";
    ejecutar($sql);
    // Redirigir automáticamente a la página principal después del registro
    header("Location: ../index.php");
    exit();
}

// Función para agregar una nueva noticia
function agregarNoticia($id_autor, $titulo, $cuerpo, $fecha)
{
    // Llamar a la función para crear la noticia desde la base de datos
    crearNoticia($id_autor, $titulo, $cuerpo, $fecha);
}

// Función para editar una noticia existente
function editarNoticia($id_noticia, $titulo, $cuerpo, $fecha)
{
    // Llamar a la función para editar la noticia desde la base de datos
    editarNoticia($id_noticia, $titulo, $cuerpo, $fecha);
    // Redirigir automáticamente a la página principal después del registro
    header("Location: ../index.php");
    exit();
}

// Función para eliminar una noticia por su ID
function eliminarNoticiaPorId($id_noticia)
{
    // Llamar a la función para eliminar la noticia desde la base de datos
    eliminarNoticia($id_noticia);
    // Redirigir de vuelta a la página principal
    header("Location: ../index.php");
    exit();
}

// Función para obtener todas las noticias
function obtenerTodasLasNoticias()
{
    // Consulta SQL para obtener todas las noticias
    $sql = "SELECT * FROM noticia";
    $resultado = consultar($sql);

    // Verificar si la consulta devolvió resultados
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $noticias = [];
        // Obtener todas las noticias y almacenarlas en un array
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $noticias[] = $fila;
        }
        return $noticias;
    } else {
        // Si no hay noticias disponibles, devolver null
        return null;
    }
}

?>