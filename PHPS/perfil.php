<?php
// Conexión a la base de datos
$host = 'localhost';
$db = 'dios'; // Nombre de tu base de datos
$user = 'root'; // Usuario predeterminado en XAMPP
$pass = ''; // Contraseña predeterminada en XAMPP (vacía)
$charset = 'utf8mb4';

// Configuración de PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Error al conectar a la base de datos: ' . $e->getMessage());
}

// Consulta de datos del usuario
$id_usuario = 1; // Cambia este valor según tu lógica
$stmt = $pdo->prepare('SELECT username, email, reg_date, role FROM usuarios WHERE id = :id');
$stmt->execute(['id' => $id_usuario]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die('Usuario no encontrado.');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="perfil.css">
</head>
<body>
    <div class="container">
        <header>
            <nav class="navbar">
                <!-- Navegación -->
            </nav>
        </header>
        <main>
            <section class="profile-section">
                <div class="profile-header">
                    <img src="imagenes/Perfil_Reinen.png" alt="Foto de perfil" class="profile-img">
                    <h1 class="username"><?php echo htmlspecialchars($user['username']); ?></h1>
                    <span class="user-type"><?php echo htmlspecialchars($user['role']); ?></span>
                </div>
                <div class="profile-details">
                    <h2>Detalles del Perfil</h2>
                    <p><strong>Nombre de usuario:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><strong>Correo electrónico:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Fecha de registro:</strong> <?php echo htmlspecialchars($user['reg_date']); ?></p>
                </div>
            </section>
        </main>
        <footer>
            <!-- Pie de página -->
        </footer>
    </div>
</body>
</html>
