<?php
require '../../vendor/autoload.php';
use TDM\EnvLoader;
use TDM\Database;

EnvLoader::load();
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? '';
$code = $input['code'] ?? '';

try {
    $pdo = Database::connect();
    // Buscar usuario
    $stmt = $pdo->prepare("SELECT verification_code FROM fans WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['verification_code'] === $code) {
        // Código Correcto -> Marcar como verificado
        $update = $pdo->prepare("UPDATE fans SET is_verified = TRUE, verification_code = NULL WHERE email = :email");
        $update->execute([':email' => $email]);

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Código incorrecto']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Error de verificación']);
}
?>