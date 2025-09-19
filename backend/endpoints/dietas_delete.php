<?php
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
    $id = $data->id;

    $sql = "DELETE FROM dietas WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Dieta eliminada con éxito"]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
} else {
    echo json_encode(["error" => "Falta el ID"]);
}

$conn->close();

