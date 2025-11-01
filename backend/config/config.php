<?php
// backend/config/config.php

require __DIR__ . '/../vendor/autoload.php';

// Chargement des variables d'environnement (.env local ou Render)
if (class_exists('Dotenv\Dotenv')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->safeLoad();
}

// Variables d'environnement PostgreSQL
$host = 'dpg-d3ug1me3jp1c73a9cesg-a.frankfurt-postgres.render.com';
$dbname = 'ecoride2026_db';
$user = 'ecoride2026_db_user';
$pass = 'ADL6GImPudvgGKZtjn0n6d3MMdYpMsOB';
$port = 5432;


try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("❌ Erreur de connexion PostgreSQL : " . $e->getMessage());
}
?>
