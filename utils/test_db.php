<?php
// Mostrar todos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';
use TDM\Database;

echo "<h1>Prueba de Conexión a Supabase</h1>";

// 1. Verificar Extensiones
echo "<h3>1. Verificando Extensiones PHP...</h3>";
if (extension_loaded('pdo_pgsql')) {
    echo "<p style='color:green'>✅ PDO PostgreSQL está habilitado.</p>";
} else {
    echo "<p style='color:red'>❌ ERROR CRÍTICO: La extensión 'php_pdo_pgsql' no está activa en tu WAMP.</p>";
    echo "<p>Solución: Clic icono WAMP -> PHP -> Extensions -> marca 'php_pdo_pgsql' y 'php_pgsql'. Reinicia WAMP.</p>";
    exit;
}

// 2. Probar Conexión
echo "<h3>2. Conectando a la Base de Datos...</h3>";
try {
    $pdo = Database::connect();
    echo "<p style='color:green'>✅ ¡Conexión Exitosa!</p>";
    
    // 3. Probar Consulta
    echo "<h3>3. Probando consulta simple...</h3>";
    $stmt = $pdo->query("SELECT NOW() as tiempo");
    $row = $stmt->fetch();
    echo "<p>Hora del servidor DB: " . $row['tiempo'] . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Falló la conexión:</p>";
    echo "<pre>" . $e->getMessage() . "</pre>";
    
    // Ayuda común
    if (strpos($e->getMessage(), 'SCRAM-SHA-256') !== false) {
        echo "<p><strong>Pista:</strong> Parece un error de contraseña o método de autenticación. Verifica tu password en el .env.</p>";
    }
    if (strpos($e->getMessage(), 'host') !== false) {
        echo "<p><strong>Pista:</strong> No se encuentra el servidor. Verifica el HOST y el PUERTO (6543) en el .env.</p>";
    }
}
?>