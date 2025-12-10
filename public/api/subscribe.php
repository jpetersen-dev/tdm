<?php
require '../../vendor/autoload.php';
use TDM\EnvLoader;
use TDM\Database;

EnvLoader::load();
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? '';
$name = $input['name'] ?? 'Viajero'; 
$optIn = $input['optIn'] ?? false;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Email inválido']);
    exit;
}

// 1. Generar Código
$code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

try {
    // 2. Guardar en Supabase
    $pdo = Database::connect();
    $sql = "INSERT INTO fans (email, name, verification_code, opt_in, updated_at) 
            VALUES (:email, :name, :code, :optin, NOW())
            ON CONFLICT (email) DO UPDATE 
            SET verification_code = :code, name = :name, updated_at = NOW()";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email, 
        ':name' => $name, 
        ':code' => $code,
        ':optin' => $optIn ? 'true' : 'false'
    ]);

    // 3. Enviar a n8n
    $webhookUrl = $_ENV['N8N_WEBHOOK_URL'] ?? getenv('N8N_WEBHOOK_URL');
    
    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['email' => $email, 'name' => $name, 'code' => $code]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // --- FIX PARA WAMP/LOCAL: IGNORAR SSL ---
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $response = curl_exec($ch);
    
    // Debug: Si falla cURL, ver por qué
    if (curl_errno($ch)) {
        throw new Exception('Error Curl: ' . curl_error($ch));
    }
    
    curl_close($ch);

    echo json_encode(['status' => 'success', 'message' => 'Código enviado']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>