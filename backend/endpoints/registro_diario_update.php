<?php
// registro_diario_update.php
include_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $db = new Database();
    $conn = $db->getConnection();

    $input = json_decode(file_get_contents('php://input'), true);

    $id = $input['id'] ?? null;
    $id_usuario = $input['id_usuario'] ?? null;
    $id_dieta = $input['id_dieta'] ?? null;
    $fecha = $input['fecha'] ?? null;
    $calorias_consumidas = $input['calorias_consumidas'] ?? null;
    $macros_consumidos = $input['macros_consumidos'] ?? null;
    $notas = $input['notas'] ?? null;

    if ($id && $id_usuario && $fecha) {
        $sql = "UPDATE registro_diario SET id_usuario=?, id_dieta=?, fecha=?, calorias_consumidas=?, macros_consumidos=?, notas=? 
                WHERE id=?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisissi", $id_usuario, $id_dieta, $fecha, $calorias_consumidas, $macros_consumidos, $notas, $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Registro diario actualizado exitosamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar registro diario"]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["error" => "Datos faltantes"]);
    }

    $conn->close();
}