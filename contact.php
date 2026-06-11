<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://cdcspa.cl');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Datos inválidos']);
    exit;
}

// Sanitizar campos
$nombre          = htmlspecialchars(trim($input['nombre'] ?? ''));
$telefono        = htmlspecialchars(trim($input['telefono'] ?? ''));
$email           = filter_var(trim($input['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$comuna          = htmlspecialchars(trim($input['comuna'] ?? ''));
$tipoProyecto    = htmlspecialchars(trim($input['tipoProyecto'] ?? ''));
$cantidadVentanas = htmlspecialchars(trim($input['cantidadVentanas'] ?? ''));
$mensaje         = htmlspecialchars(trim($input['mensaje'] ?? ''));

if (!$nombre || !$telefono || !$email || !$comuna || !$tipoProyecto || !$cantidadVentanas) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Campos obligatorios incompletos']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Correo inválido']);
    exit;
}

$destinatarios = 'marketing@cdcspa.cl, juanjose@cdcspa.cl, paulina@cdcspa.cl, contacto@cdcspa.cl';
$asunto        = "Nueva cotización CDC SPA — $nombre";

$cuerpo = "
Nueva solicitud de cotización recibida desde cdcspa.cl

Nombre:             $nombre
Teléfono/WhatsApp:  $telefono
Correo:             $email
Comuna/Región:      $comuna
Tipo de proyecto:   $tipoProyecto
Cantidad ventanas:  $cantidadVentanas
Mensaje:            " . ($mensaje ?: '—') . "

---
Enviado automáticamente desde el formulario de cdcspa.cl
";

$headers  = "From: no-reply@cdcspa.cl\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

$enviado = mail($destinatarios, $asunto, $cuerpo, $headers);

if ($enviado) {
    echo json_encode(['ok' => true]);
} else {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error al enviar el correo']);
}
