<?php
header("Content-Type: application/json");
require_once("../config/db.php");

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT id, nombre, created_at FROM nutriologos";
$result = $conn->query($sql);

$nutriologos = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $nutriologos[] = $row;
    }
}

echo json_encode($nutriologos, JSON_PRETTY_PRINT);
