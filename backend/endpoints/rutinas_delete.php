<?php
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
    $id = $data->id;

    $sql = "DELETE FROM rutinas WHERE id=$id";

    if ($conn->query($sql) === true) {
        echo json_encode(["message" => "Rutina eliminada con éxito"]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
} else {
    echo json_encode(["error" => "Falta el ID"]);
}

$conn->close();
