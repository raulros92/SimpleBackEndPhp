<!-- Conexion y funciones con la base de datos -->
<?php
require_once 'datos_conexion.php';

// Función para establecer la conexión a la base de datos
function conectar()
{
    $conexion = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    } else {
        echo "Conexión establecida con éxito"; // Mensaje de éxito
        return $conexion; // Devolver el objeto mysqli
    }
}

// Función para ejecutar consultas SELECT
function consultar($sql)
{
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    if (!$resultado) {
        die("Error al ejecutar la consulta: " . $conexion->error);
    } else {
        return $resultado;
    }
}

// Función para ejecutar consultas INSERT, UPDATE, DELETE
function ejecutar($sql)
{
    $conexion = conectar();
    if ($conexion->query($sql)) {
        // La consulta se ejecutó con éxito
        return "Consulta ejecutada con éxito";
    } else {
        // La consulta falló
        die("Error al ejecutar la consulta: " . $conexion->error);
    }
}

// Función para crear una nueva noticia
function crearNoticia($id_autor, $titulo, $cuerpo, $fecha)
{
    $sql = "INSERT INTO noticia (id_autor, titulo, cuerpo, fecha) VALUES ('$id_autor', '$titulo', '$cuerpo', '$fecha')";
    return ejecutar($sql);
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
    return $resultado->fetch_assoc();
}

// Función para actualizar una noticia
function actualizarNoticia($id, $titulo, $cuerpo, $fecha)
{
    $sql = "UPDATE noticia SET titulo = '$titulo', cuerpo = '$cuerpo', fecha = '$fecha' WHERE id = $id";
    return ejecutar($sql);
}

// Función para eliminar una noticia por su ID
function eliminarNoticia($id)
{
    $sql = "DELETE FROM noticia WHERE id = $id";
    return ejecutar($sql);
}

?>