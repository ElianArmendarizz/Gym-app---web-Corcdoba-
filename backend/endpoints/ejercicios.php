<?php
// ejercicios.php
header('Content-Type: application/json');
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT e.id, e.nombre, e.series, e.repeticiones, e.peso, e.notas, e.created_at,
               r.nombre AS rutina_nombre
        FROM ejercicios e
        LEFT JOIN rutinas r ON e.id_rutina = r.id";

$result = $conn->query($sql);

$ejercicios = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ejercicios[] = $row;
    }
}

echo json_encode($ejercicios, JSON_PRETTY_PRINT);

$conn->close();
