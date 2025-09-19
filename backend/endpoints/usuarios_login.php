<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once("../config/db.php");

$db = new Database();
$conn = $db->getConnection();

// Recibir datos en formato JSON
$data = json_decode(file_get_contents("php://input"));

if (isset($data->email) && isset($data->password)) {
    $email = $conn->real_escape_string($data->email);
    $password = $conn->real_escape_string($data->password);

    // Buscar usuario por email
    $sql = "SELECT id, email, password, rol FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verificar contraseña
        if (password_verify($password, $user['password'])) {
            // Login exitoso
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_rol'] = $user['rol'];
            
            echo json_encode([
                "success" => true, 
                "message" => "Login exitoso",
                "user" => [
                    "id" => $user['id'],
                    "email" => $user['email'],
                    "rol" => $user['rol']
                ]
            ]);
        } else {
            // Contraseña incorrecta
            echo json_encode([
                "success" => false, 
                "error" => "Credenciales incorrectas"
            ]);
        }
    } else {
        // Usuario no encontrado
        echo json_encode([
            "success" => false, 
            "error" => "Credenciales incorrectas"
        ]);
    }
} else {
    echo json_encode([
        "success" => false, 
        "error" => "Datos incompletos"
    ]);
}

$conn->close();