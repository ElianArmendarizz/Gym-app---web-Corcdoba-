<?php
// registro_diario.php
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT rd.id, rd.fecha, rd.calorias_consumidas, rd.macros_consumidos, rd.notas, rd.created_at,
               u.nombre AS usuario_nombre,
               d.nombre AS dieta_nombre
        FROM registro_diario rd
        LEFT JOIN usuarios u ON rd.id_usuario = u.id
        LEFT JOIN dietas d ON rd.id_dieta = d.id";

$result = $conn->query($sql);

$registro_diario = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $registro_diario[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($registro_diario);

$conn->close();