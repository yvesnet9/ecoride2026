<?php
require 'vendor/autoload.php';
use Dotenv\Dotenv;

try {
    // charge ton .env dans ce dossier
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    echo "✅ Chargement OK\n";
    echo "MYSQL_DATABASE = " . ($_ENV['MYSQL_DATABASE'] ?? 'non trouvé') . "\n";
    echo "MONGO_DATABASE = " . ($_ENV['MONGO_DATABASE'] ?? 'non trouvé') . "\n";
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
}
