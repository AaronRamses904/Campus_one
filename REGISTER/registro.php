<?php
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
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha = $_POST['fecha_nacimiento'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (id_usuario, nombre, apellido, fecha_nacimiento, correo, password)
            VALUES ('$id_usuario', '$nombre', '$apellido', '$fecha', '$correo', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Registro exitoso. <a href='login.php'>Inicia sesión aquí</a>";
    } else {
        echo "❌ Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>