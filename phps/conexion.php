<?php
// Datos de conexión
$host = "localhost"; // Dirección del servidor (localhost si es local)
$usuario = "root";   // Nombre de usuario
$contraseña = "";    // Contraseña
$base_de_datos = "mi_base_de_datos"; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($host, $usuario, $contraseña, $base_de_datos);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres
$conn->set_charset("utf8");
?>
