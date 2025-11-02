<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/db.php'; // connexion PostgreSQL

// Autoriser les requêtes OPTIONS (CORS preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Lecture du corps JSON
$input = json_decode(file_get_contents("php://input"), true);

if (!$input || empty($input['utilisateur_id']) || empty($input['trajet_id'])) {
    echo json_encode(["status" => "error", "message" => "Champs manquants : utilisateur_id et trajet_id requis."]);
    exit;
}

$user_id = (int)$input['utilisateur_id'];
$trajet_id = (int)$input['trajet_id'];

try {
    // Vérifier la connexion
    if (!isset($pdo)) {
        throw new Exception("Connexion à la base de données non initialisée.");
    }

    // Vérifier si le trajet existe
    $stmt = $pdo->prepare("SELECT id, places_disponibles FROM trajets WHERE id = :id");
    $stmt->execute(['id' => $trajet_id]);
    $trajet = $stmt->fetch();

    if (!$trajet) {
        echo json_encode(["status" => "error", "message" => "Trajet introuvable."]);
        exit;
    }

    if ($trajet['places_disponibles'] <= 0) {
        echo json_encode(["status" => "error", "message" => "Aucune place disponible pour ce trajet."]);
        exit;
    }

    // Vérifier si l'utilisateur a déjà réservé ce trajet
    $check = $pdo->prepare("SELECT id FROM reservations WHERE utilisateur_id = :u AND trajet_id = :t");
    $check->execute(['u' => $user_id, 't' => $trajet_id]);
    if ($check->fetch()) {
        echo json_encode(["status" => "error", "message" => "Vous avez déjà réservé ce trajet."]);
        exit;
    }

    // Insérer la réservation
    $insert = $pdo->prepare("INSERT INTO reservations (utilisateur_id, trajet_id) VALUES (:u, :t)");
    $insert->execute(['u' => $user_id, 't' => $trajet_id]);

    // Décrémenter les places disponibles
    $update = $pdo->prepare("UPDATE trajets SET places_disponibles = places_disponibles - 1 WHERE id = :id");
    $update->execute(['id' => $trajet_id]);

    echo json_encode([
        "status" => "success",
        "message" => "Réservation confirmée 🎉",
        "trajet_id" => $trajet_id
    ]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erreur SQL : " . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>

