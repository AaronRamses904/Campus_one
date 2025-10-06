<?php
session_start();

// Datos de conexión a MySQL (según docker-compose)
$servername = "db";
$username = "usuario";
$password = "pass123";
$dbname = "mi_basedatos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Error en la conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    // Verificar primero en MySQL
    $stmt = $conn->prepare("SELECT id_usuario, nombre, apellido, correo, password 
                            FROM usuarios 
                            WHERE id_usuario = ?");
    $stmt->bind_param("s", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    $usuarioEncontrado = false;

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $usuarioEncontrado = true;
        }
    }

    // Si no se encontró en MySQL, buscar en JSON
    if (!$usuarioEncontrado) {
        $jsonFile = __DIR__ . "/data/usuarios.json";
        if (file_exists($jsonFile)) {
            $usuariosData = json_decode(file_get_contents($jsonFile), true);

            foreach ($usuariosData['usuarios'] as $user) {
                if ($user['id_usuario'] === $id_usuario && password_verify($password, $user['password'])) {
                    $row = $user;
                    $usuarioEncontrado = true;
                    break;
                }
            }
        }
    }

    if ($usuarioEncontrado) {
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['apellido'] = $row['apellido'];
        $_SESSION['correo'] = $row['correo'];

        echo "✅ Bienvenido " . $row['nombre'] . " " . $row['apellido'] . 
             ". <a href='../../frontend/inicio.html'>Ir al inicio</a>";
        exit();
    } else {
        echo "❌ Credenciales incorrectas o usuario no encontrado.";
    }

    $stmt->close();
}

$conn->close();
?>



