<?php
// backend/api/register.php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/db.php'; // ✅ Connexion PDO déjà configurée

try {
    // 🔹 Lire les données JSON envoyées par le frontend React
    $input = json_decode(file_get_contents("php://input"), true);

    $name = trim($input['name'] ?? '');
    $email = trim($input['email'] ?? '');
    $password = trim($input['password'] ?? '');

    // 🔸 Validation des champs
    if (!$name || !$email || !$password) {
        echo json_encode(["status" => "error", "message" => "Tous les champs sont obligatoires."]);
        exit;
    }

    // Vérifier si l’utilisateur existe déjà
    $check = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $check->execute(['email' => $email]);
    if ($check->fetch()) {
        echo json_encode(["status" => "error", "message" => "Cet email est déjà enregistré."]);
        exit;
    }

    // Hacher le mot de passe
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insérer l’utilisateur
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, created_at) VALUES (:name, :email, :password, NOW())");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "✅ Utilisateur créé avec succès !",
        "user" => [
            "name" => $name,
            "email" => $email
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Erreur SQL : " . $e->getMessage()
    ]);
}

