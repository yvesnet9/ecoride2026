<?php
/**
 * ==============================================================
  *  FICHIER : hybrid_demo.php
   *  POSITION : backend/
    *  RÔLE     : Démonstration de la connexion combinée MySQL + MongoDB
     * ==============================================================
      */

      // 1️⃣ Connexion à MySQL
      echo "🚀 ===== CONNEXION HYBRIDE EcoRide =====\n\n";
      echo "🔹 Connexion MySQL...\n";

      $servername = "127.0.0.1";
      
      $username = "ecoride_user";
      $password = "ecoride123";
      $dbname = "ecoride_db";

      try {
          $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  echo "✅ Connexion MySQL réussie !\n";

                      // Lecture de quelques utilisateurs
                          $stmt = $pdo->query("SELECT id, name, email FROM users LIMIT 3");
                              $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                  echo "👥 Exemples d'utilisateurs MySQL :\n";
                                      foreach ($users as $user) {
                                              echo "- [ID {$user['id']}] {$user['name']} ({$user['email']})\n";
                                                  }

                                                  } catch (PDOException $e) {
                                                      echo "❌ Erreur MySQL : " . $e->getMessage() . "\n";
                                                      }

                                                      // 2️⃣ Connexion à MongoDB
                                                      echo "\n�� Connexion MongoDB...\n";

                                                      require_once __DIR__ . '/config/mongo.php'; // utilise ton fichier mongo.php

                                                      try {
                                                          echo "✅ Connexion MongoDB réussie !\n";

                                                              // Lecture de quelques logs récents
                                                                  $logs = $dbMongo->logs->find([], ['limit' => 3]);

                                                                      echo "📝 Exemples de logs MongoDB :\n";
                                                                          foreach ($logs as $log) {
                                                                                  $event = $log['event'] ?? '(inconnu)';
                                                                                          $timestamp = $log['timestamp']->toDateTime()->format('Y-m-d H:i:s');
                                                                                                  echo "- $event à $timestamp\n";
                                                                                                      }

                                                                                                      } catch (Exception $e) {
                                                                                                          echo "❌ Erreur MongoDB : " . $e->getMessage() . "\n";
                                                                                                          }

                                                                                                          // 3️⃣ Synthèse
                                                                                                          echo "\n🌿 Architecture hybride validée : MySQL + MongoDB opérationnels ✅\n";
                                                                                                          ?>
                                                                                                          
