<?php
// ====================================================
// 🌿 Fichier : backend/api/logs.php
// Rôle : Renvoie les logs MongoDB en JSON
// ====================================================

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Activer les erreurs PHP pour le débogage
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . "/../config/mongo.php";

try {
    // ✅ Connexion MongoDB via la fonction de config
        $client = getMongoConnection();
            $db = $client->selectDatabase("ecoride_logs");
                $collection = $db->selectCollection("logs");

                    // 🔹 Récupère les 50 derniers logs triés du plus récent au plus ancien
                        $cursor = $collection->find([], [
                                "limit" => 50,
                                        "sort" => ["timestamp" => -1],
                                            ]);

                                                $logs = [];
                                                    foreach ($cursor as $doc) {
                                                            $logs[] = [
                                                                        "user" => $doc["user"] ?? "Inconnu",
                                                                                    "action" => $doc["action"] ?? ($doc["event"] ?? "N/A"),
                                                                                                "ride_id" => $doc["ride_id"] ?? null,
                                                                                                            "vehicle_id" => $doc["vehicle_id"] ?? null,
                                                                                                                        "timestamp" => isset($doc["timestamp"])
                                                                                                                                        ? $doc["timestamp"]->toDateTime()->format("Y-m-d H:i:s")
                                                                                                                                                        : null,
                                                                                                                                                                ];
                                                                                                                                                                    }

                                                                                                                                                                        echo json_encode([
                                                                                                                                                                                "success" => true,
                                                                                                                                                                                        "count" => count($logs),
                                                                                                                                                                                                "logs" => $logs,
                                                                                                                                                                                                    ], JSON_PRETTY_PRINT);

                                                                                                                                                                                                    } catch (Exception $e) {
                                                                                                                                                                                                        http_response_code(500);
                                                                                                                                                                                                            echo json_encode([
                                                                                                                                                                                                                    "success" => false,
                                                                                                                                                                                                                            "error" => $e->getMessage(),
                                                                                                                                                                                                                                ]);
                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                
