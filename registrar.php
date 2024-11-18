<?php
include 'conexion.php'; // Incluir el archivo de conexión

// Obtener datos del formulario y sanitizarlos
$user = $conn->real_escape_string($_POST['username']);
$email = $conn->real_escape_string($_POST['email']);
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Insertar datos en la base de datos usando declaraciones preparadas
$stmt = $conn->prepare("INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $user, $email, $pass);

if ($stmt->execute()) {
    // Redirigir al usuario a login.html después de un registro exitoso
    header("Location: Login.html);
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>