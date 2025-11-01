<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

try {
    $host = getenv("DB_HOST") ?: "localhost";
    $port = getenv("DB_PORT") ?: "5432";
    $dbname = getenv("DB_NAME") ?: "ecoride_db";
    $user = getenv("DB_USER") ?: "postgres";
    $pass = getenv("DB_PASS") ?: "";

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "✅ Connexion PostgreSQL réussie !",
        "driver" => $pdo->getAttribute(PDO::ATTR_DRIVER_NAME),
        "version" => $pdo->getAttribute(PDO::ATTR_SERVER_VERSION)
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Erreur de connexion à PostgreSQL : " . $e->getMessage()
    ]);
}

