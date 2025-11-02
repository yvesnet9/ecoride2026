<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/db.php';

// Lecture du corps JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['reservation_id'])) {
    echo json_encode(["status" => "error", "message" => "reservation_id manquant."]);
    exit;
}

$reservation_id = intval($data['reservation_id']);

try {
    if (!isset($pdo)) {
        throw new Exception("Connexion DB non initialisée");
    }

    // Vérifie que la réservation existe
    $check = $pdo->prepare("SELECT id FROM reservations WHERE id = :id");
    $check->execute(['id' => $reservation_id]);
    if ($check->rowCount() === 0) {
        echo json_encode(["status" => "error", "message" => "Réservation introuvable."]);
        exit;
    }

    // Supprime la réservation
    $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = :id");
    $stmt->execute(['id' => $reservation_id]);

    echo json_encode([
        "status" => "success",
        "message" => "Réservation annulée 🗑️",
        "reservation_id" => $reservation_id
    ]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erreur SQL : " . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

