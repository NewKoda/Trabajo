<?php
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
        // Capturar los datos del formulario
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encriptar la contraseña

        // Insertar los datos en la tabla 'usuarios'
        $sql = "INSERT INTO usuarios (USERNAME, EMAIL, PASSWORD) VALUES (:username, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute(); // Ejecutar la consulta

        // Redirigir a la página principal después de un registro exitoso
        header("Location: Main.html");
        exit(); // Asegurarse de que no se ejecute más código después de la redirección
    }
} catch (PDOException $e) {
    // En caso de error en la conexión o consulta
    echo "Error: " . $e->getMessage();
}
?>
