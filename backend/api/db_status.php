<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../config/config.php'; // Connexion PDO

try {
    $stmt = $pdo->query("SELECT NOW() as current_time");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "success",
        "message" => "✅ Base PostgreSQL connectée",
        "time" => $row['current_time']
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "❌ Erreur de connexion PostgreSQL",
        "error" => $e->getMessage()
    ]);
}

