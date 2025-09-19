<?php
header('Content-Type: application/json');
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT d.id, d.nombre, d.calorias, d.macros, d.created_at,
               u.nombre AS usuario_nombre,
               n.nombre AS nutriologo_nombre
        FROM dietas d
        LEFT JOIN usuarios u ON d.id_usuario = u.id
        LEFT JOIN nutriologos n ON d.id_nutriologo = n.id";

$result = $conn->query($sql);

$dietas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dietas[] = $row;
    }
}

echo json_encode($dietas, JSON_PRETTY_PRINT);

$conn->close();
