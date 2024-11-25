<?php
session_start();

// Conexión a la base de datos
$host = 'localhost';
$dbname = 'dios';
$username = 'root';
$password = ''; // Cambia por tu contraseña si tienes una configurada
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar los datos enviados por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para buscar al usuario por correo
    $stmt = $conn->prepare("SELECT id, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Verificar contraseña
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Guardar datos del usuario en la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $email;

            // Mostrar mensaje de éxito
            echo "<h3>Ingreso exitoso. Redirigiendo...</h3>";

            // Redirigir al perfil o página principal
            echo "<script>
                    setTimeout(function(){
                        window.location.href = 'Main.html';
                    }, 2000); // Redirigir después de 2 segundos
                  </script>";
            exit;
        } else {
            // Contraseña incorrecta
            $error_message = "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado
        $error_message = "No se encontró una cuenta con este correo.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h3 {
            color: #d9534f;
        }
        button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .back-link {
            margin-top: 10px;
            display: inline-block;
            font-size: 14px;
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <?php
        if (isset($error_message)) {
            echo "<h3>$error_message</h3>";
        }
        ?>
        <a href="Login.html"><button>Volver al Login</button></a>
    </div>
</body>
</html>
