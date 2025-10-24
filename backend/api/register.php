<?php
/**
 * ===========================================
  * 🌿 EcoRide - API d'inscription utilisateur
   * Backend : PHP + MySQL (PDO)
    * Date : 2025-10-23
     * ===========================================
      *
       * Étapes :
        * 1️⃣ Récupérer les données envoyées par le frontend (name, email, password)
         * 2️⃣ Vérifier que l’utilisateur n’existe pas déjà
          * 3️⃣ Hasher le mot de passe (password_hash)
           * 4️⃣ Enregistrer l’utilisateur dans la base MySQL
            * 5️⃣ Retourner un JSON au frontend
             */

             // ------------------------------
             // 1️⃣ Configuration CORS + JSON
             // ------------------------------
             header("Access-Control-Allow-Origin: *");
             header("Access-Control-Allow-Methods: POST, OPTIONS");
             header("Access-Control-Allow-Headers: Content-Type");
             header("Content-Type: application/json; charset=UTF-8");

             // Si la requête est une pré-vérification (OPTIONS)
             if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
                 http_response_code(200);
                     exit();
                     }

                     // ------------------------------
                     // 2️⃣ Connexion à la base de données
                     // ------------------------------
                     require_once __DIR__ . '/../config/db.php';

                     // ------------------------------
                     // 3️⃣ Lecture des données JSON reçues
                     // ------------------------------
                     $input = json_decode(file_get_contents("php://input"), true);

                     if (
                         !isset($input['name']) ||
                             !isset($input['email']) ||
                                 !isset($input['password'])
                                 ) {
                                     echo json_encode([
                                             "status" => "error",
                                                     "message" => "Nom, email et mot de passe requis."
                                                         ]);
                                                             exit;
                                                             }

                                                             $name = trim($input['name']);
                                                             $email = trim($input['email']);
                                                             $password = trim($input['password']);

                                                             // ------------------------------
                                                             // 4️⃣ Vérifie si l’utilisateur existe déjà
                                                             // ------------------------------
                                                             try {
                                                                 $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                                                                     $check->execute([$email]);
                                                                         $existingUser = $check->fetch();

                                                                             if ($existingUser) {
                                                                                     echo json_encode([
                                                                                                 "status" => "error",
                                                                                                             "message" => "Cet utilisateur existe déjà."
                                                                                                                     ]);
                                                                                                                             exit;
                                                                                                                                 }

                                                                                                                                     // ------------------------------
                                                                                                                                         // 5️⃣ Hash du mot de passe
                                                                                                                                             // ------------------------------
                                                                                                                                                 $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                                                                                                                                                     // ------------------------------
                                                                                                                                                         // 6️⃣ Insertion de l’utilisateur
                                                                                                                                                             // ------------------------------
                                                                                                                                                                 $insert = $pdo->prepare(
                                                                                                                                                                         "INSERT INTO users (name, email, role, password_hash)
                                                                                                                                                                                  VALUES (?, ?, 'passenger', ?)"
                                                                                                                                                                                      );

                                                                                                                                                                                          $insert->execute([$name, $email, $passwordHash]);

                                                                                                                                                                                              // ------------------------------
                                                                                                                                                                                                  // 7️⃣ Réponse au frontend
                                                                                                                                                                                                      // ------------------------------
                                                                                                                                                                                                          echo json_encode([
                                                                                                                                                                                                                  "status" => "success",
                                                                                                                                                                                                                          "message" => "Utilisateur créé avec succès 🎉",
                                                                                                                                                                                                                                  "data" => [
                                                                                                                                                                                                                                              "name" => $name,
                                                                                                                                                                                                                                                          "email" => $email,
                                                                                                                                                                                                                                                                      "role" => "passenger"
                                                                                                                                                                                                                                                                              ]
                                                                                                                                                                                                                                                                                  ]);
                                                                                                                                                                                                                                                                                  } catch (Exception $e) {
                                                                                                                                                                                                                                                                                      http_response_code(500);
                                                                                                                                                                                                                                                                                          echo json_encode([
                                                                                                                                                                                                                                                                                                  "status" => "error",
                                                                                                                                                                                                                                                                                                          "message" => "Erreur serveur : " . $e->getMessage()
                                                                                                                                                                                                                                                                                                              ]);
                                                                                                                                                                                                                                                                                                              }
                                                                                                                                                                                                                                                                                                              
