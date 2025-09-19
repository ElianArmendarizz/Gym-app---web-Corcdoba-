<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once("../config/db.php");

$db = new Database();
$conn = $db->getConnection();

// Recibir datos en formato JSON
$data = json_decode(file_get_contents("php://input"));
// isset es una función de PHP que verifica si un objeto existe y tiene un valor no nulo
if (isset($data->nombre) && isset($data->email) && isset($data->password) && isset($data->rol)) {
    $nombre = $conn->real_escape_string($data->nombre);
    $email = $conn->real_escape_string($data->email);
    $password = $conn->real_escape_string($data->password);
    $rol = $conn->real_escape_string($data->rol);
    
    // Encriptar la contraseña (IMPORTANTE para seguridad)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES ('$nombre', '$email', '$hashed_password', '$rol')";

    if ($conn->query($sql)) {
        echo json_encode(["success" => true, "message" => "Usuario creado correctamente"]);
    } else {
        echo json_encode(["success" => false, "error" => "Error al insertar usuario: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Datos incompletos"]);
}

$conn->close();