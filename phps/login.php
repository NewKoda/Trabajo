<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mi_base_de_datos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$email = $_POST['email'];
$pass = $_POST['password'];

// Verificar datos en la base de datos
$sql = "SELECT * FROM usuarios WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Verificar contraseña
    $row = $result->fetch_assoc();
    if (password_verify($pass, $row['password'])) {
        echo "Inicio de sesión exitoso";
        // Aquí puedes redirigir al usuario a otra página o iniciar una sesión
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo "No se encontró el usuario";
}

$conn->close();
?>