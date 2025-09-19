<?php
include_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $db = new Database();
    $conn = $db->getConnection();

    $input = json_decode(file_get_contents('php://input'), true);

    $id = $input['id'] ?? null;
    $id_rutina = $input['id_rutina'] ?? null;
    $nombre = $input['nombre'] ?? null;
    $series = $input['series'] ?? null;
    $repeticiones = $input['repeticiones'] ?? null;
    $peso = $input['peso'] ?? null;
    $notas = $input['notas'] ?? null;

    if ($id && $nombre && $id_rutina) {
        $sql = "UPDATE ejercicios SET id_rutina=?, nombre=?, series=?, repeticiones=?, peso=?, notas=? 
                WHERE id=?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isisdsi", $id_rutina, $nombre, $series, $repeticiones, $peso, $notas, $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Ejercicio actualizado exitosamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar ejercicio"]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["error" => "Datos faltantes"]);
    }

    $conn->close();
}
