<?php
// ====================================================
// 🌿 Fichier : backend/api/contact.php
// Rôle : gérer les messages du formulaire de contact (MySQL)
// - POST → envoi d’un nouveau message
// - GET  → récupération de tous les messages
// ====================================================

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Autoriser les requêtes préflight CORS
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . "/../config/db_mysql.php"; // ✅ Connexion MySQL

try {
    $pdo = getMySQLConnection();

    // ==========================================
    // 📨 1️⃣ Récupération de tous les messages (GET)
    // ==========================================
    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["all"])) {
        $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "success" => true,
            "count" => count($messages),
            "messages" => $messages
        ], JSON_PRETTY_PRINT);
        exit;
    }

    // ==========================================
    // 💌 2️⃣ Envoi d’un nouveau message (POST)
    // ==========================================
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $data = json_decode(file_get_contents("php://input"), true);

        // Vérification des champs
        if (
            empty($data["name"]) ||
            empty($data["email"]) ||
            empty($data["message"])
        ) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "error" => "Champs manquants"
            ]);
            exit;
        }

        // Insertion dans la base MySQL
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$data["name"], $data["email"], $data["message"]]);

        echo json_encode([
            "success" => true,
            "message" => "Message enregistré avec succès"
        ]);
        exit;
    }

    // ==========================================
    // ❌ 3️⃣ Méthode non autorisée
    // ==========================================
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "error" => "Méthode non autorisée"
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Erreur MySQL : " . $e->getMessage()
    ]);
}
