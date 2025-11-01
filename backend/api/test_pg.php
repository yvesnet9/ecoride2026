<?php
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . '/../config/db.php';

require_once __DIR__ . '/../config/db.php';

$env = [
    "DB_HOST" => getenv("DB_HOST"),
    "DB_PORT" => getenv("DB_PORT"),
    "DB_NAME" => getenv("DB_NAME"),
    "DB_USER" => getenv("DB_USER"),
    "DB_PASS" => getenv("DB_PASS")
];

try {
    $dsn = sprintf(
        "pgsql:host=%s;port=%s;dbname=%s",
        $env["DB_HOST"] ?: "localhost",
        $env["DB_PORT"] ?: "5432",
        $env["DB_NAME"] ?: "ecoride_db"
    );

    $pdo = new PDO($dsn, $env["DB_USER"], $env["DB_PASS"], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "✅ Connexion PostgreSQL réussie sur Render !",
        "host" => $env["DB_HOST"],
        "version" => $pdo->getAttribute(PDO::ATTR_SERVER_VERSION)
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Erreur de connexion PostgreSQL : " . $e->getMessage(),
        "env" => $env
    ]);
}

