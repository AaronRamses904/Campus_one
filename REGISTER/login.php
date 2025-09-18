<?php
session_start();

// Datos de conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campus_one";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];
    $password = $_POST['password'];

    $sql = "SELECT id, id_usuario, nombre, apellido, correo, password 
            FROM usuarios 
            WHERE id_usuario = '$id_usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Guardar sesión
            $_SESSION['id'] = $row['id'];
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['apellido'] = $row['apellido'];
            $_SESSION['correo'] = $row['correo'];

            echo "✅ Bienvenido " . $row['nombre'] . " " . $row['apellido'] .
                ". <a href='../inicio.html'>Ir al inicio</a>";
            exit();
        } else {
            echo "❌ Contraseña incorrecta.";
        }
    } else {
        echo "❌ El ID de usuario no existe.";
    }
}

$conn->close();
?>