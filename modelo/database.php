<!-- Conexion y funciones con la base de datos -->
<?php
require_once("datos_conexion.php");
require_once("../controlador/controlador.php");

// Función para establecer la conexión a la base de datos
function conectar()
{
    $conexion = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    } else {
        echo "Conexión establecida con éxito"; // Mensaje de éxito
        return $conexion;
    }
}

// Función para cerrar la conexión a la base de datos
function cerrarConexion($conexion)
{
    mysqli_close($conexion);
}

// Función para ejecutar consultas SELECT
function consultar($sql)
{
    $conexion = conectar();
    $resultado = mysqli_query($conexion, $sql);
    if (!$resultado) {
        die("Error al ejecutar la consulta: " . mysqli_error($conexion));
    } else {
        cerrarConexion($conexion); // Cerrar la conexión
        return $resultado;
    }
}

// Función para ejecutar consultas INSERT, UPDATE, DELETE
function ejecutar($sql)
{
    $conexion = conectar();
    if (mysqli_query($conexion, $sql)) {
        // La consulta se ejecutó con éxito
        echo "Consulta ejecutada con éxito"; // Mensaje de éxito
    } else {
        // La consulta falló
        die("Error al ejecutar la consulta: " . mysqli_error($conexion));
    }
    cerrarConexion($conexion); // Cerrar la conexión
}

// Función para crear una nueva noticia
function crearNoticia($id_autor, $titulo, $cuerpo, $fecha)
{
    $sql = "INSERT INTO noticia (id_autor, titulo, cuerpo, fecha) VALUES ('$id_autor', '$titulo', '$cuerpo', '$fecha')";
    ejecutar($sql);
}

// Función para obtener todas las noticias
function obtenerNoticias()
{
    $sql = "SELECT * FROM noticia";
    return consultar($sql);
}

// Función para obtener una noticia por su ID
function obtenerNoticiaPorId($id)
{
    $sql = "SELECT * FROM noticia WHERE id = $id";
    $resultado = consultar($sql);
    return mysqli_fetch_assoc($resultado);
}

// Función para actualizar una noticia
function actualizarNoticia($id, $titulo, $cuerpo, $fecha)
{
    $sql = "UPDATE noticia SET titulo = '$titulo', cuerpo = '$cuerpo', fecha = '$fecha' WHERE id = $id";
    ejecutar($sql);
}

// Función para eliminar una noticia por su ID
function eliminarNoticia($id)
{
    $sql = "DELETE FROM noticia WHERE id = $id";
    ejecutar($sql);
}

// Función para obtener el ID del usuario por su correo electrónico
function obtenerIdUsuarioPorEmail($email)
{
    // Consulta SQL para obtener el ID del usuario por su correo electrónico
    $sql = "SELECT id FROM usuarios WHERE email='$email'";

    // Ejecutar la consulta
    $resultado = consultar($sql);

    // Verificar si se encontró el usuario
    if ($fila = mysqli_fetch_assoc($resultado)) {
        return $fila['id'];
    } else {
        // Si el usuario no existe, devolver null o algún otro valor predeterminado
        return null;
    }
}

?>