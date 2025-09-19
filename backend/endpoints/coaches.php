<?php
header("Content-Type: application/json");
require_once("../config/db.php");

$db = new Database();
$conn = $db->getConnection();

$sql = "SELECT id, nombre, especialidad, email FROM coaches";
$result = $conn->query($sql);

$coaches = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $coaches[] = $row;
    }
}

echo json_encode($coaches, JSON_PRETTY_PRINT);
