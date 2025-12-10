<?php
namespace TDM;

use Dotenv\Dotenv;

class EnvLoader {
    public static function load() {
        // La raíz del proyecto es dos niveles arriba de 'src'
        $rootDir = dirname(__DIR__);

        // Solo cargamos .env si el archivo existe (Entorno Local)
        if (file_exists($rootDir . '/.env')) {
            $dotenv = Dotenv::createImmutable($rootDir);
            $dotenv->safeLoad();
        }
    }
}
?>