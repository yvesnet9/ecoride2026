<?php
// backend/api/login.php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// 🔁 Réponse immédiate pour les requêtes OPTIONS (CORS preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/db.php'; // Connexion PDO à Render PostgreSQL

// 🔒 Lire le corps JSON envoyé
$input = json_decode(file_get_contents('php://input'), true);
$email = trim($input['email'] ?? '');
$password = trim($input['password'] ?? '');

// 🚨 Vérification des champs obligatoires
if (empty($email) || empty($password)) {
    echo json_encode([
        "status" => "error",
        "message" => "Veuillez fournir un email et un mot de passe."
    ]);
    exit;
}

try {
    // 🔍 Rechercher l'utilisateur dans PostgreSQL
    $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode([
            "status" => "error",
            "message" => "Utilisateur non trouvé."
        ]);
        exit;
    }

    // 🔑 Vérifier le mot de passe haché (password_hash)
    if (!password_verify($password, $user['password'])) {
        echo json_encode([
            "status" => "error",
            "message" => "Mot de passe incorrect."
        ]);
        exit;
    }

    // 🎟️ Générer un token simple (à remplacer plus tard par JWT)
    $token = bin2hex(random_bytes(16));

    echo json_encode([
        "status" => "success",
        "message" => "Connexion réussie 🎉",
        "user" => [
            "id" => $user['id'],
            "email" => $user['email']
        ],
        "token" => $token
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Erreur SQL : " . $e->getMessage()
    ]);
}

