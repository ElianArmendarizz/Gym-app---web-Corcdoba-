<?php
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->nombre) && isset($data->id_usuario) && isset($data->id_coach)) {
    $nombre = $conn->real_escape_string($data->nombre);
    $descripcion = isset($data->descripcion) ? $conn->real_escape_string($data->descripcion) : '';
    $id_usuario = (int)$data->id_usuario;
    $id_coach = (int)$data->id_coach;

    // Verificar existencia de usuario y coach
    $checkUsuario = $conn->query("SELECT id FROM usuarios WHERE id=$id_usuario");
    $checkCoach = $conn->query("SELECT id FROM coaches WHERE id=$id_coach");

    if ($checkUsuario->num_rows === 0) {
        echo json_encode(["error" => "El usuario con ID $id_usuario no existe"]);
        exit;
    }
    if ($checkCoach->num_rows === 0) {
        echo json_encode(["error" => "El coach con ID $id_coach no existe"]);
        exit;
    }

    // Insertar rutina
    $sql = "INSERT INTO rutinas (nombre, descripcion, id_usuario, id_coach)
            VALUES ('$nombre', '$descripcion', $id_usuario, $id_coach)";

    if ($conn->query($sql) === true) {
        echo json_encode(["message" => "Rutina creada con éxito"]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
} else {
    echo json_encode(["error" => "Datos incompletos"]);
}

$conn->close();

