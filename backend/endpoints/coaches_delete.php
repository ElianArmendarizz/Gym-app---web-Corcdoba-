<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once("../config/db.php");

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
    $id = (int)$data->id;

    $sql = "DELETE FROM coaches WHERE id=$id";

    if ($conn->query($sql)) {
        echo json_encode(["message" => "Coach eliminado correctamente"]);
    } else {
        echo json_encode(["error" => "Error al eliminar coach"]);
    }
} else {
    echo json_encode(["error" => "ID no proporcionado"]);
}
