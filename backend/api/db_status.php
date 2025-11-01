<?php
// backend/api/db_status.php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Réponse rapide pour OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/db.php';

try {
    // 🧪 Test simple : récupérer la version du serveur PostgreSQL
    $stmt = $pdo->query("SELECT version();");
    $version = $stmt->fetchColumn();

    echo json_encode([
        "status" => "success",
        "message" => "✅ Connexion PostgreSQL réussie sur Render !",
        "host" => getenv('DB_HOST') ?: 'inconnu',
        "version" => $version
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Erreur de connexion PostgreSQL : " . $e->getMessage(),
        "env" => [
            "DB_HOST" => getenv('DB_HOST'),
            "DB_PORT" => getenv('DB_PORT'),
            "DB_NAME" => getenv('DB_NAME'),
            "DB_USER" => getenv('DB_USER'),
            "DB_PASS" => getenv('DB_PASS')
        ]
    ]);
}

