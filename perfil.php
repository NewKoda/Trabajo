<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html"); // Redirige al login si no está logueado
    exit;
}

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

// Obtén los datos del usuario desde la base de datos
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email FROM usuarios WHERE id = ?"); // Eliminado el campo fecha_registro
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    // Si no se encuentra el usuario, destruye la sesión y redirige al login
    session_destroy();
    header("Location: Login.html");
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="Styles/perfil.css">
</head>
<body>
    <div class="container">
        <header>
            <nav class="navbar">
                <a href="MainLogin.html" style="text-decoration: none;">
                    <div class="logo-container">
                        <img src="imagenes/Logo.png" alt="Logo Liga de Ensueño" class="logo-img">
                    </div>
                </a>
                <div class="nav-center">
                    <ul class="nav-links">
                        <a href="Liga login.html" style="text-decoration: none;">
                            <li>Liga de Ensueño</li>
                        </a>                    
                        <a href="Novedades_con_loginn.html" style="text-decoration: none;">
                            <li>Novedades</li>
                        </a>
                        <a href="USUARIOS_con_loginn.html" style="text-decoration: none;">
                            <li>Usuarios</li>
                        </a>
                    </ul>
                </div>
                <a href="logout.php" style="text-decoration: none;">
                    <button class="login-button">Cerrar Sesión</button>
                </a>
            </nav>
        </header>   
        <main>
            <section class="profile-section">
                <div class="profile-header">
                    <img src="imagenes/personaje_12.png" alt="Foto de perfil" class="profile-img">
                    <h1 class="username"><?php echo htmlspecialchars($user['username']); ?></h1>
                    <span class="user-type">Usuario registrado</span>
                </div>
                <div class="profile-details">
                    <h2>Detalles del Perfil</h2>
                    <p><strong>Nombre de usuario:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><strong>Correo electrónico:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </section>
        </main>
        <footer>
            <div class="footer-content">
                <div class="footer-links">
                    <a href="informacion Login.html">Sobre Nosotros</a>
                    <a href="informacion Login.html">Información</a>
                </div>
                <div class="footer-links">
                    <p>Nuestras redes sociales</p>
                    <div class="social-icons">
                        <a href="https://www.instagram.com/">
                            <img src="imagenes/icon _instagram alt_.png" alt="Instagram">
                        </a>
                        <a href="https://www.facebook.com/">
                            <img src="imagenes/icon _facebook_.png" alt="Facebook">
                        </a>
                        <a href="https://web.whatsapp.com/">
                            <img src="imagenes/icon _whatsapp_.png" alt="WhatsApp">
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
