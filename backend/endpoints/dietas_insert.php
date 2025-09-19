<?php
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->nombre) && isset($data->id_usuario) && isset($data->id_nutriologo)) {
    $nombre = $data->nombre;
    $calorias = $data->calorias ?? 0;
    $macros = $data->macros ?? '';
    $id_usuario = $data->id_usuario;
    $id_nutriologo = $data->id_nutriologo;

    $sql = "INSERT INTO dietas (nombre, calorias, macros, id_usuario, id_nutriologo)
            VALUES ('$nombre', $calorias, '$macros', $id_usuario, $id_nutriologo)";

    if ($conn->query($sql) === true) {
        echo json_encode(["message" => "Dieta creada con éxito"]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
} else {
    echo json_encode(["error" => "Datos incompletos"]);
}

$conn->close();
