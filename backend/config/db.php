<?php
// backend/config/db.php
// Connexion silencieuse à PostgreSQL sur Render (avec SSL)

$host = getenv('DB_HOST') ?: 'localhost';
$db   = getenv('DB_NAME') ?: 'ecoride2026_db';
$user = getenv('DB_USER') ?: 'ecoride2026_db_user';
$pass = getenv('DB_PASS') ?: '';
$port = getenv('DB_PORT') ?: '5432';

// 🧩 Créer la variable $pdo disponible globalement
try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    // ⚠️ En cas d’erreur, enregistrer dans un log et retourner une réponse JSON si besoin
    error_log("Erreur de connexion PostgreSQL : " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "❌ Erreur de connexion à la base de données"
    ]);
    exit;
}

