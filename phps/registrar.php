<?php
// Iniciar sesión si es necesario para la redirección posterior
session_start();

// Incluir archivo de conexión con la base de datos
include('conexion.php'); // Asegúrate de que este archivo esté configurado correctamente

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $username = mysqli_real_escape_string($conexion, $_POST['username']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);
    $terms = isset($_POST['terms']) ? 1 : 0; // Comprobar si se aceptaron los términos

    // Encriptar la contraseña antes de almacenarla
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO usuarios (username, email, password, terms_accepted) 
            VALUES ('$username', '$email', '$passwordHash', '$terms')";

    if (mysqli_query($conexion, $sql)) {
        // Redirigir a una página de éxito o a la página principal después de registrar al usuario
        $_SESSION['mensaje'] = 'Registro exitoso, por favor inicia sesión.';
        header("Location: login.html");
        exit();
    } else {
        // Si hay un error con la base de datos
        echo "Error: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>
