<?php
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
    $id = $data->id;
    $peso = $data->peso ?? 0;
    $medidas = $data->medidas ?? '';
    $fecha = $data->fecha ?? date('Y-m-d');
    $id_usuario = $data->id_usuario ?? 'NULL';

    $sql = "UPDATE progreso SET
                peso=$peso,
                medidas='$medidas',
                fecha='$fecha',
                id_usuario=$id_usuario
            WHERE id=$id";

    if ($conn->query($sql) === true) {
        echo json_encode(["message" => "Progreso actualizado con éxito"]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
} else {
    echo json_encode(["error" => "Falta el ID"]);
}

$conn->close();
