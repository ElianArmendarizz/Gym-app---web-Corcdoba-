<?php
// sesiones_entrenamiento_delete.php
include_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $db = new Database();
    $conn = $db->getConnection();

    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'] ?? null;

    if ($id) {
        $sql = "DELETE FROM sesiones_entrenamiento WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Sesión de entrenamiento eliminada exitosamente"]);
        } else {
            echo json_encode(["error" => "Error al eliminar sesión de entrenamiento"]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["error" => "ID no proporcionado"]);
    }

    $conn->close();
}