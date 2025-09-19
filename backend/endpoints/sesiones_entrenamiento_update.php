<?php
// sesiones_entrenamiento_update.php
include_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $db = new Database();
    $conn = $db->getConnection();

    $input = json_decode(file_get_contents('php://input'), true);

    $id = $input['id'] ?? null;
    $id_usuario = $input['id_usuario'] ?? null;
    $id_rutina = $input['id_rutina'] ?? null;
    $fecha = $input['fecha'] ?? null;
    $duracion = $input['duracion'] ?? null;
    $calorias_quemadas = $input['calorias_quemadas'] ?? null;
    $completada = $input['completada'] ?? 0;
    $notas = $input['notas'] ?? null;

    if ($id && $id_usuario && $fecha) {
        $sql = "UPDATE sesiones_entrenamiento SET id_usuario=?, id_rutina=?, fecha=?, duracion=?, calorias_quemadas=?, completada=?, notas=? 
                WHERE id=?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisiiiis", $id_usuario, $id_rutina, $fecha, $duracion, $calorias_quemadas, $completada, $notas, $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Sesión de entrenamiento actualizada exitosamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar sesión de entrenamiento"]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["error" => "Datos faltantes"]);
    }

    $conn->close();
}