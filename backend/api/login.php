<?php
// backend/api/login.php

// ------------------------------
// 1️⃣ En-têtes HTTP (CORS + JSON)
// ------------------------------
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// ------------------------------
// 2️⃣ Si c’est une requête OPTIONS → fin (préflight)
// ------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
    exit();
    }

    // ------------------------------
    // 3️⃣ Connexion à la base MySQL
    // ------------------------------
    require_once __DIR__ . '/../config/db.php'; // fichier de connexion MySQL

    // ------------------------------
    // 4️⃣ Lecture des données envoyées (email + password)
    // ------------------------------
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['email']) || !isset($data['password'])) {
      echo json_encode(["status" => "error", "message" => "Email et mot de passe requis."]);
        exit;
        }

        $email = trim($data['email']);
        $password = trim($data['password']);

        // ------------------------------
        // 5️⃣ Requête SQL préparée pour éviter les injections
        // ------------------------------
        $stmt = $pdo->prepare("SELECT id, name, email, role, password_hash FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
          echo json_encode(["status" => "error", "message" => "Utilisateur non trouvé."]);
            exit;
            }

            // ------------------------------
            // 6️⃣ Vérification du mot de passe
            // ------------------------------
            if (!password_verify($password, $user['password_hash'])) {
              echo json_encode(["status" => "error", "message" => "Mot de passe incorrect."]);
                exit;
                }

                // ------------------------------
                // 7️⃣ Si tout est bon → renvoyer les infos utilisateur (sans le hash !)
                // ------------------------------
                echo json_encode([
                  "status" => "success",
                    "message" => "Connexion réussie.",
                      "data" => [
                          "id" => $user['id'],
                              "name" => $user['name'],
                                  "email" => $user['email'],
                                      "role" => $user['role']
                                        ]
                                        ]);
                                        
