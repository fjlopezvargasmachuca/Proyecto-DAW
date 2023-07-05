<?php
// Datos del correo electrónico
$destinatario = 'eligecoche1987@gmail.com';
$asunto = 'Asunto del correo';
$contenido = $_POST['mensaje'];  // Obtener el contenido del cuadro de texto

// Configurar los datos del correo electrónico
$data = array(
    'from' => $from,
    'to' => $destinatario,
    'subject' => $asunto,
    'text' => $contenido
);
// Crear la solicitud POST
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $apikey);

// Enviar la solicitud y obtener la respuesta
$response = curl_exec($ch);
curl_close($ch);

// Verificar la respuesta
if ($response === false) {
    echo 'Error al enviar la solicitud.';
} else {
    echo 'Correo enviado correctamente.';
}
?>