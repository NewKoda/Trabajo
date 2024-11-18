<?php
// Incluir el archivo de conexión
include 'conexion.php'; // Asegúrate de que el archivo 'conexion.php' esté en el mismo directorio

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibiendo los valores del formulario
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cifrar la contraseña para mayor seguridad
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta SQL para insertar los datos en la tabla
    $sql = "INSERT INTO usuarios (username, email, password) VALUES ('$username', '$email', '$password_hash')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Nuevo perfil creado con éxito.";
        header('Location: success.html'); // Redirigir a una página de éxito (puedes crearla si lo deseas)
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>
