<?php
if(!isset($_GET['info'])){
    $datos = "https://josprox.com/";
}else{
    $datos = $_GET['info'];
}
// URL de la API de QR Code Generator
$apiUrl = 'https://qrcode.tec-it.com/API/QRCode';

// Parámetros de configuración del código QR
$params = [
    'data' => $datos, // URL o texto para codificar en el código QR
    'backcolor' => 'FFFFFF', // Color de fondo del código QR (en formato hexadecimal)
    'forecolor' => '000000', // Color de primer plano del código QR (en formato hexadecimal)
    'format' => 'png', // Formato de imagen del código QR
    'version' => '10', // Versión del código QR
    'eclevel' => 'H', // Nivel de corrección de errores del código QR
];

// Construir la URL de la API con los parámetros
$apiUrl .= '?' . http_build_query($params);

// Mostrar la imagen del código QR
header('Content-Type: image/png');
echo file_get_contents($apiUrl);

?>