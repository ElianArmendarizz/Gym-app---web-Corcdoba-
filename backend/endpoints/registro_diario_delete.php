<?php
// registro_diario_delete.php
include_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $db = new Database();
    $conn = $db->getConnection();

    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'] ?? null;

    if ($id) {
        $sql = "DELETE FROM registro_diario WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Registro diario eliminado exitosamente"]);
        } else {
            echo json_encode(["error" => "Error al eliminar registro diario"]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["error" => "ID no proporcionado"]);
    }

    $conn->close();
}