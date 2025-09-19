<?php
header('Content-Type: application/json');
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT r.id, r.nombre, r.descripcion, r.created_at,
               u.nombre AS usuario_nombre,
               c.nombre AS coach_nombre
        FROM rutinas r
        LEFT JOIN usuarios u ON r.id_usuario = u.id
        LEFT JOIN coaches c ON r.id_coach = c.id";

$result = $conn->query($sql);

$rutinas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rutinas[] = $row;
    }
}

echo json_encode($rutinas, JSON_PRETTY_PRINT);

$conn->close();

