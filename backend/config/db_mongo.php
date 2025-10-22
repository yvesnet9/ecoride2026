<?php
/**
 * ========================================================
 * EcoRide 2026 - Connexion MongoDB
 * ========================================================
 * Cette configuration gère la connexion à la base NoSQL
 * utilisée pour les avis passagers et les logs du système.
 *
 * ⚙️ Bonne pratique :
 *  - Utilisation de MongoDB\Client (extension officielle)
 *  - Gestion d'erreur propre via try/catch
 *  - Variables d’environnement pour la sécurité
 *  - Encodage UTF-8
 */

require_once __DIR__ . '/../../vendor/autoload.php'; // charge l’autoload Composer si dispo

use MongoDB\Client;

$MONGO_URI = $_ENV['MONGO_URI'] ?? 'mongodb://localhost:27017';
$MONGO_DB  = $_ENV['MONGO_DATABASE'] ?? 'ecoride_nosql';

try {
    // Connexion à MongoDB
    $mongoClient = new Client($MONGO_URI);
    $mongoDB = $mongoClient->selectDatabase($MONGO_DB);

    // 🔄 Message de confirmation (optionnel en dev)
    // echo "✅ Connexion MongoDB réussie : base $MONGO_DB\n";

} catch (Exception $e) {
    http_response_code(500);
    die(json_encode([
        "error" => "Erreur de connexion MongoDB",
        "message" => $e->getMessage()
    ]));
}
