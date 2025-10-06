<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

// Ruta del archivo JSON local
$jsonFile = __DIR__ . "/data/usuarios.json";

// Leer datos del formulario
$data = json_decode(file_get_contents("php://input"), true);

$id_usuario = $data["id_usuario"] ?? null;
$correo = $data["correo"] ?? null;
$password = $data["password"] ?? null;

if (!$id_usuario || !$correo || !$password) {
    echo json_encode(["status" => "error", "message" => "Faltan datos"]);
    exit;
}

// Crear el archivo si no existe
if (!file_exists($jsonFile)) {
    file_put_contents($jsonFile, json_encode([], JSON_PRETTY_PRINT));
}

// Leer usuarios actuales
$usuarios = json_decode(file_get_contents($jsonFile), true);

// Validar si el usuario ya existe
foreach ($usuarios as $u) {
    if ($u["id_usuario"] === $id_usuario || $u["correo"] === $correo) {
        echo json_encode(["status" => "error", "message" => "Usuario o correo ya registrado"]);
        exit;
    }
}

// Agregar nuevo usuario
$usuarios[] = [
    "id_usuario" => $id_usuario,
    "correo" => $correo,
    "password" => password_hash($password, PASSWORD_DEFAULT)
];

// Guardar localmente
file_put_contents($jsonFile, json_encode($usuarios, JSON_PRETTY_PRINT));

// Subir automáticamente a S3 (requiere AWS CLI configurado)
$bucket = "campus-one-datos";
$cmd = "aws s3 cp " . escapeshellarg($jsonFile) . " s3://$bucket/usuarios.json";
shell_exec($cmd);

// Respuesta final
echo json_encode(["status" => "success", "message" => "Usuario registrado y sincronizado con S3"]);
?>





