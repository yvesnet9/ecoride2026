<?php
/**
 * ======================================================
 *  EcoRide 2026 - Connexion MySQL (PDO)
 * ------------------------------------------------------
 *  Gère la connexion à la base de données relationnelle.
 *  Chargement via .env + PDO sécurisé + gestion d’erreurs.
 * ======================================================
 */

require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

class MySQLConnection {
    private $pdo;

    public function __construct() {
        // 🔁 Chargement du fichier .env
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        // 🧩 Lecture des variables d’environnement
        $host = $_ENV['MYSQL_HOST'] ?? 'localhost';
        $dbname = $_ENV['MYSQL_DATABASE'] ?? 'ecoride_db';
        $user = $_ENV['MYSQL_USER'] ?? 'root';
        $pass = $_ENV['MYSQL_PASSWORD'] ?? '';

        // 🔒 Options PDO (sécurité + performance)
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // exceptions sur erreurs SQL
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // résultats sous forme de tableaux associatifs
            PDO::ATTR_EMULATE_PREPARES   => false,                  // désactive l’émulation pour sécurité
        ];

        // 🧠 Tentative de connexion
        try {
            $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $user, $pass, $options);
            echo "✅ Connexion MySQL réussie à la base : {$dbname}\n";
        } catch (PDOException $e) {
            echo "❌ Erreur MySQL : " . $e->getMessage() . "\n";
            exit;
        }
    }

    /**
     * Retourne l’instance PDO active
     */
    public function getConnection() {
        return $this->pdo;
    }
}
