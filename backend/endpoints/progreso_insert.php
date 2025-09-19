<?php
header('Content-Type: application/json');
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id_usuario) && isset($data->peso) && isset($data->medidas) && isset($data->fecha)) {
    $id_usuario = $data->id_usuario;
    $peso = $data->peso;
    $medidas = $data->medidas;
    $fecha = $data->fecha;

    $sql = "INSERT INTO progreso (id_usuario, peso, medidas, fecha)
            VALUES ($id_usuario, $peso, '$medidas', '$fecha')";

    if ($conn->query($sql) === true) {
        echo json_encode(["message" => "Progreso registrado con éxito"]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
} else {
    echo json_encode(["error" => "Datos incompletos"]);
}

$conn->close();
