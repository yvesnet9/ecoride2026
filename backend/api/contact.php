<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/db.php'; // Connexion PostgreSQL

try {
    // 🔍 Lecture du JSON reçu
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || empty($data['nom']) || empty($data['email']) || empty($data['message'])) {
        echo json_encode(["status" => "error", "message" => "Tous les champs sont obligatoires."]);
        exit;
    }

    $nom = trim($data['nom']);
    $email = trim($data['email']);
    $message = trim($data['message']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Adresse e-mail invalide."]);
        exit;
    }

    // ✅ Création de la table si elle n’existe pas encore
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS messages (
            id SERIAL PRIMARY KEY,
            nom VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL,
            message TEXT NOT NULL,
            date_envoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // 💾 Insertion du message
    $stmt = $pdo->prepare("
        INSERT INTO messages (nom, email, message)
        VALUES (:nom, :email, :message)
    ");
    $stmt->execute([
        ':nom' => $nom,
        ':email' => $email,
        ':message' => $message
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Message reçu avec succès 🌿",
        "data" => [
            "nom" => $nom,
            "email" => $email,
            "date_envoi" => date('Y-m-d H:i:s')
        ]
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Erreur SQL : " . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Erreur serveur : " . $e->getMessage()
    ]);
}

