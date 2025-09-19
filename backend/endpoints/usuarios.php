<?php
header("Content-Type: application/json");

require_once("../config/db.php");

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT id, nombre, email FROM usuarios";
$result = $conn->query($sql);

$usuarios = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}

echo json_encode($usuarios, JSON_PRETTY_PRINT);
