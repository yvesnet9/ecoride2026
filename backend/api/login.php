<?php
// =====================================================
// 🎯 /api/login.php — Authentification utilisateur
// =====================================================

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Charger la connexion PostgreSQL
require_once __DIR__ . '/../config/db.php';

// Vérifier méthode HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée"]);
    exit;
}

// Lire le JSON envoyé
$input = json_decode(file_get_contents("php://input"), true);
$email = trim($input['email'] ?? '');
$password = trim($input['password'] ?? '');

// Vérifier champs
if (empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Email et mot de passe requis"]);
    exit;
}

try {
    // Rechercher l’utilisateur dans la base
    $stmt = $pdo->prepare("SELECT id, email, password, nom FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Utilisateur non trouvé"]);
        exit;
    }

    // Vérifier le mot de passe (haché)
    if (!password_verify($password, $user['password'])) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Mot de passe incorrect"]);
        exit;
    }

    // Générer un token simple (JWT possible plus tard)
    $token = bin2hex(random_bytes(24));

    echo json_encode([
        "status" => "success",
        "message" => "Connexion réussie 🎉",
        "user" => [
            "id" => $user['id'],
            "email" => $user['email'],
            "nom" => $user['nom']
        ],
        "token" => $token
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Erreur serveur : " . $e->getMessage()
    ]);
}

