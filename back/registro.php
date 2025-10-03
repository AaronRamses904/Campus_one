<?php
// Datos de conexión a MySQL (según docker-compose)
$servername = "db";
$username = "usuario";
$password = "pass123";
$dbname = "mi_basedatos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Error en la conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $correo = $_POST['correo'];
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Consulta preparada (sin 'id')
    $stmt = $conn->prepare("INSERT INTO usuarios 
        (id_usuario, nombre, apellido, fecha_nacimiento, correo, password) 
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $id_usuario, $nombre, $apellido, $fecha_nacimiento, $correo, $passwordHash);

    if ($stmt->execute()) {
        echo "✅ Registro exitoso. <a href='/frontend/index.html'>Inicia sesión aquí</a>";
    } else {
        echo "❌ Error en el registro: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>