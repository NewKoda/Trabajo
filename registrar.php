<?php
// Configuración de la base de datos
$host = 'sql113.infinityfree.com'; // Tu Host Name
$dbname = 'if0_37779085_Usuarios'; // Tu DB Name
$user = 'if0_37779085'; // Tu User Name
$password = '8MTQqlveVL8go'; // Tu Password

// Conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Verificar si los datos fueron enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar los datos
    if (!empty($username) && !empty($email) && !empty($password)) {
        // Hashear la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar los datos en la base de datos
        $sql = "INSERT INTO Usuarios (USERNAME, EMAIL, PASSWORD) VALUES (:username, :email, :password)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashed_password,
            ]);
            echo "Usuario registrado con éxito. <a href='login.html'>Inicia sesión aquí</a>.";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Código para entrada duplicada
                echo "El correo ya está registrado.";
            } else {
                echo "Error al registrar el usuario: " . $e->getMessage();
            }
        }
    } else {
        echo "Por favor, completa todos los campos.";
    }
}
?>
