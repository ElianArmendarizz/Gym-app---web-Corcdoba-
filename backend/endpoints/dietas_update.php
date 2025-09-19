<?php
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
    $id = $data->id;
    $nombre = $data->nombre ?? '';
    $calorias = $data->calorias ?? 0;
    $macros = $data->macros ?? '';
    $id_usuario = $data->id_usuario ?? 'NULL';
    $id_nutriologo = $data->id_nutriologo ?? 'NULL';

    $sql = "UPDATE dietas SET
                nombre='$nombre',
                calorias=$calorias,
                macros='$macros',
                id_usuario=$id_usuario,
                id_nutriologo=$id_nutriologo
            WHERE id=$id";

    if ($conn->query($sql) === true) {
        echo json_encode(["message" => "Dieta actualizada con éxito"]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
} else {
    echo json_encode(["error" => "Falta el ID"]);
}

$conn->close();

