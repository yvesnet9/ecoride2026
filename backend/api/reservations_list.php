<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/db.php';

// 🔹 Récupère l'ID utilisateur
$utilisateur_id = $_GET['utilisateur_id'] ?? null;

if (!$utilisateur_id) {
    echo json_encode(["status" => "error", "message" => "utilisateur_id manquant"]);
    exit;
}

try {
    if (!isset($pdo)) {
        throw new Exception("Connexion à la base non initialisée");
    }

    // 🔹 Récupère les réservations avec les infos de trajet
    $stmt = $pdo->prepare("
        SELECT 
            r.id AS reservation_id,
            t.conducteur,
            t.depart,
            t.destination,
            t.date_depart,
            t.prix,
            r.date_reservation,
            r.statut
        FROM reservations r
        JOIN trajets t ON r.trajet_id = t.id
        WHERE r.utilisateur_id = :uid
        ORDER BY r.date_reservation DESC
    ");
    $stmt->execute(['uid' => $utilisateur_id]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "success",
        "count" => count($reservations),
        "reservations" => $reservations
    ]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erreur SQL : " . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

