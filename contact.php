<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: https://cdcspa.cl');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Metodo no permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Datos invalidos']);
    exit;
}

$nombre           = htmlspecialchars(trim($input['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
$telefono         = htmlspecialchars(trim($input['telefono'] ?? ''), ENT_QUOTES, 'UTF-8');
$email            = filter_var(trim($input['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$comuna           = htmlspecialchars(trim($input['comuna'] ?? ''), ENT_QUOTES, 'UTF-8');
$tipoProyecto     = htmlspecialchars(trim($input['tipoProyecto'] ?? ''), ENT_QUOTES, 'UTF-8');
$cantidadVentanas = htmlspecialchars(trim($input['cantidadVentanas'] ?? ''), ENT_QUOTES, 'UTF-8');
$mensaje          = htmlspecialchars(trim($input['mensaje'] ?? ''), ENT_QUOTES, 'UTF-8');
$fecha            = date('d-m-Y H:i:s');

if (!$nombre || !$telefono || !$email || !$comuna || !$tipoProyecto || !$cantidadVentanas) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Campos obligatorios incompletos']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Correo invalido']);
    exit;
}

$destinatarios = 'marketing.cdcspa@gmail.com, juanjose@cdcspa.cl, paulina@cdcspa.cl, contacto@cdcspa.cl';
$asunto        = "Nueva cotizacion CDC SPA - $nombre";

$html = '<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#F5F5F7;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#F5F5F7;padding:32px 0;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(26,60,94,0.10);">
<tr><td style="background:#1A3C5E;padding:32px 40px;text-align:center;">
  <div style="border:2px solid #EA580C;border-radius:8px;padding:6px 18px;display:inline-block;margin-bottom:10px;">
    <span style="color:#ffffff;font-size:22px;font-weight:900;letter-spacing:3px;">CDC SPA</span>
  </div>
  <div style="color:#EA580C;font-size:11px;letter-spacing:2px;text-transform:uppercase;margin-top:4px;">Cierres de Cristal</div>
</td></tr>
<tr><td style="padding:32px 40px 8px;text-align:center;">
  <h1 style="margin:0;font-size:22px;color:#1A3C5E;font-weight:800;">Formulario de Cotizacion</h1>
  <p style="margin:8px 0 0;color:#8A8A8E;font-size:13px;">Un cliente ha completado el formulario de contacto.</p>
  <p style="margin:4px 0 0;color:#8A8A8E;font-size:12px;">' . $fecha . '</p>
</td></tr>
<tr><td style="padding:16px 40px 0;">
  <div style="height:2px;background:#EA580C;border-radius:2px;"></div>
</td></tr>
<tr><td style="padding:24px 40px;">
  <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;">
    <tr style="background:#F5F5F7;"><td colspan="2" style="padding:12px 20px;font-size:12px;font-weight:700;color:#1A3C5E;letter-spacing:1px;text-transform:uppercase;">Datos del cliente</td></tr>
    <tr style="border-top:1px solid #e5e7eb;">
      <td style="padding:12px 20px;font-size:13px;color:#8A8A8E;width:40%;font-weight:600;">Nombre</td>
      <td style="padding:12px 20px;font-size:13px;color:#1A3C5E;font-weight:700;">' . $nombre . '</td>
    </tr>
    <tr style="border-top:1px solid #e5e7eb;background:#fafafa;">
      <td style="padding:12px 20px;font-size:13px;color:#8A8A8E;font-weight:600;">Telefono / WhatsApp</td>
      <td style="padding:12px 20px;font-size:13px;color:#1A3C5E;font-weight:700;">' . $telefono . '</td>
    </tr>
    <tr style="border-top:1px solid #e5e7eb;">
      <td style="padding:12px 20px;font-size:13px;color:#8A8A8E;font-weight:600;">Email</td>
      <td style="padding:12px 20px;font-size:13px;"><a href="mailto:' . $email . '" style="color:#EA580C;">' . $email . '</a></td>
    </tr>
    <tr style="border-top:1px solid #e5e7eb;background:#fafafa;">
      <td style="padding:12px 20px;font-size:13px;color:#8A8A8E;font-weight:600;">Comuna / Region</td>
      <td style="padding:12px 20px;font-size:13px;color:#1A3C5E;font-weight:700;">' . $comuna . '</td>
    </tr>
    <tr style="border-top:1px solid #e5e7eb;">
      <td style="padding:12px 20px;font-size:13px;color:#8A8A8E;font-weight:600;">Tipo de proyecto</td>
      <td style="padding:12px 20px;font-size:13px;color:#1A3C5E;font-weight:700;">' . $tipoProyecto . '</td>
    </tr>
    <tr style="border-top:1px solid #e5e7eb;background:#fafafa;">
      <td style="padding:12px 20px;font-size:13px;color:#8A8A8E;font-weight:600;">Cantidad ventanas</td>
      <td style="padding:12px 20px;font-size:13px;color:#1A3C5E;font-weight:700;">' . $cantidadVentanas . '</td>
    </tr>
  </table>
</td></tr>
<tr><td style="padding:0 40px 24px;">
  <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;">
    <tr style="background:#F5F5F7;"><td style="padding:12px 20px;font-size:12px;font-weight:700;color:#1A3C5E;letter-spacing:1px;text-transform:uppercase;">Mensaje</td></tr>
    <tr style="border-top:1px solid #e5e7eb;">
      <td style="padding:16px 20px;font-size:13px;color:#4A4A4A;line-height:1.6;">' . ($mensaje ?: 'Sin mensaje adicional') . '</td>
    </tr>
  </table>
</td></tr>
<tr><td style="background:#1A3C5E;padding:20px 40px;text-align:center;">
  <a href="https://cdcspa.cl" style="color:#EA580C;font-size:12px;text-decoration:none;font-weight:700;">www.cdcspa.cl</a>
  <p style="margin:6px 0 0;color:#8A8A8E;font-size:11px;">Enviado automaticamente desde el formulario de cdcspa.cl</p>
</td></tr>
</table>
</td></tr>
</table>
</body>
</html>';

$headers  = "From: no-reply@cdcspa.cl\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$enviado = mail($destinatarios, $asunto, $html, $headers);

if ($enviado) {
    echo json_encode(['ok' => true]);
} else {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error al enviar']);
}
