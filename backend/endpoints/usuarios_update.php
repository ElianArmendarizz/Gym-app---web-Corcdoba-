<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type");

require_once("../config/db.php");

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id) && isset($data->nombre) && isset($data->email)) {
    $id = (int)$data->id;
    $nombre = $conn->real_escape_string($data->nombre);
    $email = $conn->real_escape_string($data->email);

    $sql = "UPDATE usuarios SET nombre='$nombre', email='$email' WHERE id=$id";

    if ($conn->query($sql)) {
        echo json_encode(["message" => "Usuario actualizado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al actualizar usuario"]);
    }
} else {
    echo json_encode(["error" => "Datos incompletos"]);
}
