<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type");

require_once("../config/db.php");

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id) && isset($data->nombre) && isset($data->especialidad) && isset($data->horario) && isset($data->email)) {
    $id = (int)$data->id;
    $nombre = $conn->real_escape_string($data->nombre);
    $especialidad = $conn->real_escape_string($data->especialidad);
    $horario = $conn->real_escape_string($data->horario);
    $email = $conn->real_escape_string($data->email);

    $sql = "UPDATE coaches 
            SET nombre='$nombre', especialidad='$especialidad', horario='$horario', email='$email'
            WHERE id=$id";

    if ($conn->query($sql)) {
        echo json_encode(["message" => "Coach actualizado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al actualizar coach"]);
    }
} else {
    echo json_encode(["error" => "Datos incompletos"]);
}
