<?php
session_start();

// Datos de conexión a MySQL (según docker-compose)
$servername = "db"; 
$username   = "usuario";
$password   = "pass123";
$dbname     = "mi_basedatos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Error en la conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];
    $password   = $_POST['password'];

    // Consulta preparada
    $stmt = $conn->prepare("SELECT id_usuario, nombre, apellido, correo, password 
                            FROM usuarios 
                            WHERE id_usuario = ?");
    $stmt->bind_param("s", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Guardar variables de sesión
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nombre']     = $row['nombre'];
            $_SESSION['apellido']   = $row['apellido'];
            $_SESSION['correo']     = $row['correo'];

            echo "✅ Bienvenido " . $row['nombre'] . " " . $row['apellido'] .
                 ". <a href='../inicio.html'>Ir al inicio</a>";
            exit();
        } else {
            echo "❌ Contraseña incorrecta.";
        }
    } else {
        echo "❌ El ID de usuario no existe.";
    }

    $stmt->close();
}

$conn->close();
?>


