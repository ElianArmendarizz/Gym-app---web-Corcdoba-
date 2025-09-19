<?php
// sesiones_entrenamiento_insert.php
include_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    $input = json_decode(file_get_contents('php://input'), true);

    $id_usuario = $input['id_usuario'] ?? null;
    $id_rutina = $input['id_rutina'] ?? null;
    $fecha = $input['fecha'] ?? date('Y-m-d');
    $duracion = $input['duracion'] ?? null;
    $calorias_quemadas = $input['calorias_quemadas'] ?? null;
    $completada = $input['completada'] ?? 0;
    $notas = $input['notas'] ?? null;

    if ($id_usuario && $fecha) {
        $sql = "INSERT INTO sesiones_entrenamiento (id_usuario, id_rutina, fecha, duracion, calorias_quemadas, completada, notas) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisiiii", $id_usuario, $id_rutina, $fecha, $duracion, $calorias_quemadas, $completada, $notas);

        if ($stmt->execute()) {
            $response = [
                "message" => "Sesión de entrenamiento creada exitosamente",
                "id" => $conn->insert_id
            ];
            echo json_encode($response);
        } else {
            echo json_encode(["error" => "Error al crear sesión de entrenamiento"]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["error" => "Datos faltantes"]);
    }

    $conn->close();
}