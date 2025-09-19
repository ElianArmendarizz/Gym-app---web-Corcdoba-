<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once("../config/db.php");

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->nombre)) {
    $nombre = $conn->real_escape_string($data->nombre);

    $sql = "INSERT INTO nutriologos (nombre) VALUES ('$nombre')";

    if ($conn->query($sql)) {
        echo json_encode(["message" => "Nutriólogo agregado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al insertar nutriólogo"]);
    }
} else {
    echo json_encode(["error" => "Datos incompletos"]);
}
