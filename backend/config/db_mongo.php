<?php
/**
 * ======================================================
 *  EcoRide 2026 - Connexion MongoDB
 * ------------------------------------------------------
 *  Gère la connexion à la base NoSQL MongoDB.
 *  Charge les variables d'environnement depuis .env
 *  et retourne une instance MongoDB\Database.
 * ======================================================
 */

require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
use MongoDB\Client;

class MongoConnection {
    private $client;
    private $db;

    public function __construct() {
        // Chargement des variables d’environnement
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $uri = $_ENV['MONGO_URI'] ?? 'mongodb://localhost:27017';
        $database = $_ENV['MONGO_DATABASE'] ?? 'ecoride_nosql';

        try {
            // Connexion MongoDB
            $this->client = new Client($uri);
            $this->db = $this->client->selectDatabase($database);

            echo "✅ Connexion MongoDB réussie à la base : {$database}\n";
        } catch (Exception $e) {
            echo "❌ Erreur MongoDB : " . $e->getMessage() . "\n";
            exit;
        }
    }

    /**
     * Retourne la base de données MongoDB
     */
    public function getDatabase() {
        return $this->db;
    }
}
