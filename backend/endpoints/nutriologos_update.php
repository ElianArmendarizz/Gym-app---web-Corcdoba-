<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type");

require_once("../config/db.php");

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id) && isset($data->nombre)) {
    $id = (int)$data->id;
    $nombre = $conn->real_escape_string($data->nombre);

    $sql = "UPDATE nutriologos SET nombre='$nombre' WHERE id=$id";

    if ($conn->query($sql)) {
        echo json_encode(["message" => "Nutriólogo actualizado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al actualizar nutriólogo"]);
    }
} else {
    echo json_encode(["error" => "Datos incompletos"]);
}
