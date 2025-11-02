<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/db.php';

// --- Lecture robuste du corps JSON ---
$raw = file_get_contents("php://input");

// Debug temporaire
file_put_contents(__DIR__ . "/debug_register.txt", "RAW:\n" . $raw . "\n\n_POST:\n" . print_r($_POST, true));

$data = json_decode($raw, true);
if (!$data || !is_array($data)) {
    $data = $_POST;
}

// --- Validation des champs ---
if (empty($data['nom']) || empty($data['email']) || empty($data['mot_de_passe'])) {
    echo json_encode(["status" => "error", "message" => "Tous les champs sont obligatoires."]);
    exit;
}

$nom = trim($data['nom']);
$email = trim($data['email']);
$mot_de_passe = trim($data['mot_de_passe']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Adresse email invalide."]);
    exit;
}

if (strlen($mot_de_passe) < 6) {
    echo json_encode(["status" => "error", "message" => "Le mot de passe doit contenir au moins 6 caractères."]);
    exit;
}

$hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

try {
    $check = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
    $check->execute(['email' => $email]);
    if ($check->fetch()) {
        echo json_encode(["status" => "error", "message" => "Cet email est déjà enregistré."]);
        exit;
    }

    $stmt = $pdo->prepare("
        INSERT INTO utilisateurs (nom, email, mot_de_passe, role, date_creation)
        VALUES (:nom, :email, :mot_de_passe, 'passager', NOW())
    ");
    $stmt->execute([
        'nom' => $nom,
        'email' => $email,
        'mot_de_passe' => $hash
    ]);

    echo json_encode(["status" => "success", "message" => "Utilisateur créé avec succès."]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erreur SQL : " . $e->getMessage()]);
}
?>

