<?php
// Cargar Composer (sube un nivel para encontrar vendor)
require '../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;

// --- CONFIG ---
$url = 'https://teoriademaicol.onrender.com'; // URL de Render (cuando la tengas)
$logo = '../public/assets/img/logo_tdm.jpg';
$salida = '../public/assets/img/qr_afiche.png';

$rojo = new Color(238, 64, 54);
$blanco = new Color(255, 255, 255);

$result = Builder::create()
    ->writer(new PngWriter())
    ->data($url)
    ->encoding(new Encoding('UTF-8'))
    ->errorCorrectionLevel(ErrorCorrectionLevel::High)
    ->size(1000)
    ->margin(10)
    ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
    ->foregroundColor($rojo)
    ->backgroundColor($blanco)
    ->logoPath($logo)
    ->logoResizeToWidth(250)
    ->logoPunchoutBackground(true)
    ->build();

$result->saveToFile($salida);
echo "QR Generado en: $salida";
?>