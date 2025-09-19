<?php
// sesiones_entrenamiento.php
include_once "../config/db.php";

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT se.id, se.fecha, se.duracion, se.calorias_quemadas, se.completada, se.notas, se.created_at,
               u.nombre AS usuario_nombre,
               r.nombre AS rutina_nombre
        FROM sesiones_entrenamiento se
        LEFT JOIN usuarios u ON se.id_usuario = u.id
        LEFT JOIN rutinas r ON se.id_rutina = r.id";

$result = $conn->query($sql);

$sesiones_entrenamiento = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sesiones_entrenamiento[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($sesiones_entrenamiento);

$conn->close();