<?php
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT p.id, p.peso, p.medidas, p.fecha, p.created_at,
               u.nombre AS usuario_nombre
        FROM progreso p
        LEFT JOIN usuarios u ON p.id_usuario = u.id";

$result = $conn->query($sql);

$progreso = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $progreso[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($progreso);

$conn->close();
