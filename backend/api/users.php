<?php
// ====================================================
// 🌿 Fichier : backend/api/users.php
// Rôle : Renvoie les utilisateurs MySQL en JSON
// ====================================================

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/db.php'; // connexion MySQL

try {
    $stmt = $pdo->query("SELECT id, name, email, role, created_at FROM users ORDER BY id ASC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                    "status" => "success",
                            "count" => count($users),
                                    "data" => $users
                                        ], JSON_PRETTY_PRINT);
                                        } catch (PDOException $e) {
                                            http_response_code(500);
                                                echo json_encode([
                                                        "status" => "error",
                                                                "message" => $e->getMessage()
                                                                    ]);
                                                                    }
                                                                    
