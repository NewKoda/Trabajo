<?php
session_start();
include 'conexion.php'; // Incluir el archivo de conexión

// Obtener datos del formulario y sanitizarlos
$email = $conn->real_escape_string($_POST['email']);
$pass = $_POST['password'];

// Verificar datos en la base de datos usando declaraciones preparadas
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Verificar contraseña
    $row = $result->fetch_assoc();
    if (password_verify($pass, $row['password'])) {
        // Inicio de sesión exitoso
        $_SESSION['user_id'] = $row['id'];
        header("Location: perfil.php");
        exit();
    } else {
        // Contraseña incorrecta
        echo "Contraseña incorrecta";
    }
} else {
    // No se encontró el usuario
    echo "No se encontró el usuario";
}

$stmt->close();
$conn->close();
?>