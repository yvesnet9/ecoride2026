<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/db.php';

// --- Lecture la plus robuste possible du corps JSON ---
$raw = file_get_contents("php://input");

// Debug pour savoir ce que Render reçoit
file_put_contents(__DIR__ . "/debug_login.txt", "RAW:\n" . $raw . "\n\n_POST:\n" . print_r($_POST, true));

$data = json_decode($raw, true);
if (!$data || !is_array($data)) {
    $data = $_POST;
}

// --- Vérifie les champs requis ---
if (empty($data['email']) || empty($data['mot_de_passe'])) {
    echo json_encode(["status" => "error", "message" => "Veuillez fournir un email et un mot de passe."]);
    exit;
}

$email = trim($data['email']);
$mot_de_passe = trim($data['mot_de_passe']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Adresse email invalide."]);
    exit;
}

try {
    if (!isset($pdo)) {
        throw new Exception("Connexion à la base de données non initialisée.");
    }

    $stmt = $pdo->prepare("SELECT id, nom, email, mot_de_passe, date_creation FROM utilisateurs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user) {
        echo json_encode(["status" => "error", "message" => "Utilisateur introuvable."]);
        exit;
    }

    if (!password_verify($mot_de_passe, $user['mot_de_passe'])) {
        echo json_encode(["status" => "error", "message" => "Mot de passe incorrect."]);
        exit;
    }

    echo json_encode([
        "status" => "success",
        "message" => "Connexion réussie.",
        "user" => [
            "id" => $user['id'],
            "nom" => $user['nom'],
            "email" => $user['email'],
            "date_creation" => $user['date_creation']
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erreur SQL : " . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>

