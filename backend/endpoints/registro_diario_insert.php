<?php
// registro_diario_insert.php
include_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    $input = json_decode(file_get_contents('php://input'), true);

    $id_usuario = $input['id_usuario'] ?? null;
    $id_dieta = $input['id_dieta'] ?? null;
    $fecha = $input['fecha'] ?? date('Y-m-d');
    $calorias_consumidas = $input['calorias_consumidas'] ?? null;
    $macros_consumidos = $input['macros_consumidos'] ?? null;
    $notas = $input['notas'] ?? null;

    if ($id_usuario && $fecha) {
        $sql = "INSERT INTO registro_diario (id_usuario, id_dieta, fecha, calorias_consumidas, macros_consumidos, notas) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisiss", $id_usuario, $id_dieta, $fecha, $calorias_consumidas, $macros_consumidos, $notas);

        if ($stmt->execute()) {
            $response = [
                "message" => "Registro diario creado exitosamente",
                "id" => $conn->insert_id
            ];
            echo json_encode($response);
        } else {
            echo json_encode(["error" => "Error al crear registro diario"]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(["error" => "Datos faltantes"]);
    }

    $conn->close();
}