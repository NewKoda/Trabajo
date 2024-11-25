<?php
// Iniciar sesión para guardar la información del usuario
session_start();

// Mostrar errores de PHP (para depuración)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Datos de conexión a la base de datos
$host = "localhost";
$dbname = "dios";  // Nombre de tu base de datos
$username = "root";  // Usuario de MySQL
$password = "";  // Sin contraseña en XAMPP por defecto

try {
    // Crear la conexión PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si el formulario ha sido enviado
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Validación de los datos del formulario
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Comprobar que no están vacíos
        if (empty($username) || empty($email) || empty($password)) {
            echo "Todos los campos son obligatorios.";
            exit;
        }

        // Verificar si el email ya existe en la base de datos
        $sql = "SELECT COUNT(*) FROM usuarios WHERE EMAIL = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo "Este correo electrónico ya está registrado.";
            exit;
        }

        // Encriptar la contraseña
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insertar los datos en la tabla 'usuarios'
        $sql = "INSERT INTO usuarios (USERNAME, EMAIL, PASSWORD) VALUES (:username, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            // Guardar el nombre de usuario en la sesión
            $_SESSION['username'] = $username;

            // Mostrar el mensaje de éxito
            echo "<h2>¡Felicidades! Ya eres uno de nosotros.</h2>";
            echo "<p>Serás redirigido en 3 segundos...</p>";

            // Redirigir después de 3 segundos
            header("Refresh: 3; url=Login.html");
            exit();
        } else {
            // Si ocurre un error en la inserción, mostrar detalles del error
            print_r($stmt->errorInfo()); // Muestra los detalles del error
            echo "Hubo un error al registrar el usuario. Inténtalo nuevamente.";
        }
    }
} catch (PDOException $e) {
    // En caso de error en la conexión o consulta
    echo "Error de conexión o consulta: " . $e->getMessage();
}
?>
