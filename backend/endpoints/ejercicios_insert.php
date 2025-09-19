<?php
include_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    $input = json_decode(file_get_contents('php://input'), true);

    $id_rutina = $input['id_rutina'] ?? null;
    $nombre = $input['nombre'] ?? null;
    $series = $input['series'] ?? null;
    $repeticiones = $input['repeticiones'] ?? null;
    $peso = $input['peso'] ?? null;
    $notas = $input['notas'] ?? null;

    if ($nombre && $id_rutina) {
        $sql = "INSERT INTO ejercicios (id_rutina, nombre, series, repeticiones, peso, notas)
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isisds", $id_rutina, $nombre, $series, $repeticiones, $peso, $notas);

        if ($stmt->execute()) {
            $response = [
                "message" => "Ejercicio creado exitosamente",
                "id" => $conn->insert_id
            ];
            echo json_encode($response);
        } else {
            echo json_encode(["error" => "Error al crear ejercicio"]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["error" => "Datos faltantes"]);
    }

    $conn->close();
}