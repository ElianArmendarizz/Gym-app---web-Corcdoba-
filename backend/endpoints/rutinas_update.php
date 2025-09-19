<?php
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
    $id = $data->id;
    $nombre = $data->nombre ?? '';
    $descripcion = $data->descripcion ?? '';
    $id_usuario = $data->id_usuario ?? 'NULL';
    $id_coach = $data->id_coach ?? 'NULL';

    $sql = "UPDATE rutinas SET
                nombre='$nombre',
                descripcion='$descripcion',
                id_usuario=$id_usuario,
                id_coach=$id_coach
            WHERE id=$id";

    if ($conn->query($sql) === true) {
        echo json_encode(["message" => "Rutina actualizada con éxito"]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
} else {
    echo json_encode(["error" => "Falta el ID"]);
}

$conn->close();