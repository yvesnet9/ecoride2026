<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
require_once __DIR__ . '/../config/db.php';

try {
    $stmt = $pdo->query("SELECT * FROM trajets ORDER BY date_depart ASC");
    $trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "success",
        "count" => count($trajets),
        "trajets" => $trajets
    ], JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Erreur SQL : " . $e->getMessage()
    ]);
}
?>

