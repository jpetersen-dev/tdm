<?php
// --- FIX DE MEMORIA ---
// Aumentamos el límite temporalmente a 512MB para procesar imágenes grandes
ini_set('memory_limit', '512M'); 

// Cargar Composer
require '../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;

// --- CONFIGURACIÓN DE RUTAS ---
// Asegúrate de que esta URL sea la de producción (Render)
$urlDestino = 'https://tdm-4l52.onrender.com/'; 
$rutaLogo = '../public/assets/img/logo_tdm.jpg'; 
$rutaSalida = '../public/assets/img/qr_master_tdm.png';

// --- PALETA DE COLORES ---
// Rojo TDM (#EE4036)
$rojoTDM = new Color(238, 64, 54);
$blanco = new Color(255, 255, 255);

try {
    // Verificar si el logo existe antes de empezar
    if (!file_exists($rutaLogo)) {
        throw new Exception("No se encuentra el archivo del logo en: $rutaLogo");
    }

    $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data($urlDestino)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(ErrorCorrectionLevel::High)
        ->size(1200) // Alta resolución
        ->margin(10)
        ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
        
        // Estilo: Puntos Rojos sobre Blanco
        ->foregroundColor($rojoTDM)
        ->backgroundColor($blanco)
        
        // Logo
        ->logoPath($rutaLogo)
        ->logoResizeToWidth(280) // Un poco más grande para que se vea bien
        ->logoPunchoutBackground(true)
        
        ->build();

    // Guardar archivo
    $result->saveToFile($rutaSalida);

    echo "<body style='background: #333; color: white; font-family: sans-serif; text-align: center; padding: 50px;'>";
    echo "<h1>✅ QR Generado con Éxito</h1>";
    echo "<p>Memoria usada: " . round(memory_get_peak_usage() / 1024 / 1024, 2) . " MB</p>";
    echo "<img src='$rutaSalida' style='width: 400px; border: 10px solid white; border-radius: 10px;'>";
    echo "<p>Archivo guardado en: <strong>$rutaSalida</strong></p>";
    echo "</body>";

} catch (Exception $e) {
    echo "<body style='background: #333; color: #ff6b6b; font-family: sans-serif; padding: 50px;'>";
    echo "<h1>❌ Error Fatal</h1>";
    echo "<h3>" . $e->getMessage() . "</h3>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</body>";
}
?>