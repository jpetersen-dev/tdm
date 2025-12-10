<?php
// Habilitar reporte de errores para debug (quitar en producción final)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
use TDM\SpotifyService;

header('Content-Type: application/json');

try {
    $service = new SpotifyService();
    $albums = $service->getAlbums();

    // Verificación estricta
    if (empty($albums)) {
        // Si llega aquí, conectó pero no trajo nada (¿ID de artista incorrecto?)
        throw new Exception("Conexión exitosa, pero no se encontraron álbumes para el ID proporcionado.");
    }

    echo json_encode($albums);

} catch (Exception $e) {
    // En lugar de mostrar los discos falsos (mock), vamos a mostrar el error real
    // para que puedas arreglarlo.
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString() // Esto ayuda mucho a ver dónde falló
    ]);
}
?>