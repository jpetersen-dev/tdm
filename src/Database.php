<?php
namespace TDM;
use PDO;
use PDOException;

class Database {
    public static function connect() {
        EnvLoader::load();
        
        $host = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
        $db   = $_ENV['DB_NAME'] ?? getenv('DB_NAME');
        $user = $_ENV['DB_USER'] ?? getenv('DB_USER');
        $pass = $_ENV['DB_PASS'] ?? getenv('DB_PASS');
        $port = $_ENV['DB_PORT'] ?? getenv('DB_PORT');

        // CORRECCIÓN: Agregamos sslmode=require
        $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => true,
            // Timeout para que no se quede colgado si falla la red
            PDO::ATTR_TIMEOUT => 5, 
        ];

        try {
            return new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            // En desarrollo (local), mostramos el error real para debuggear.
            // En producción deberías quitar esto o usar error_log.
            die("Error de Conexión DB: " . $e->getMessage());
        }
    }
}
?>