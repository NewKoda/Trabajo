<?php
// db.php - Conexión a la base de datos
$servername = "localhost";  // Nombre del servidor de la base de datos
$username = "root";         // Usuario de la base de datos
$password = "";             // Contraseña de la base de datos (puede ser vacía en XAMPP)
$dbname = "dios";  // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
