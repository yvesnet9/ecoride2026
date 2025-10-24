<?php
/**
 * ==============================================================
  *  FICHIER : hybrid_web.php
   *  POSITION : backend/
    *  RÔLE     : Afficher les données MySQL + MongoDB dans le navigateur
     * ==============================================================
      */
      require_once __DIR__ . '/config/mongo.php';

      // Connexion MySQL
      $servername = "127.0.0.1";
      $username = "ecoride_user";
      $password = "ecoride123";
      $dbname = "ecoride_db";

      try {
          $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  $users = $pdo->query("SELECT id, name, email, role FROM users LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
                  } catch (PDOException $e) {
                      $mysql_error = $e->getMessage();
                      }

                      try {
                          $logs = $dbMongo->logs->find([], ['limit' => 5]);
                          } catch (Exception $e) {
                              $mongo_error = $e->getMessage();
                              }
                              ?>
                              <!DOCTYPE html>
                              <html lang="fr">
                              <head>
                                <meta charset="UTF-8">
                                  <title>EcoRide - Démo Hybride</title>
                                    <style>
                                        body { font-family: Arial, sans-serif; background: #f8f9fa; color: #333; margin: 40px; }
                                            h1, h2 { color: #00695c; }
                                                table { border-collapse: collapse; width: 100%; margin-bottom: 40px; }
                                                    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
                                                        th { background-color: #e0f2f1; }
                                                            .success { color: green; font-weight: bold; }
                                                                .error { color: red; font-weight: bold; }
                                                                  </style>
                                                                  </head>
                                                                  <body>
                                                                    <h1>🌿 Démonstration Hybride EcoRide</h1>

                                                                      <h2>Connexion MySQL</h2>
                                                                        <?php if (!isset($mysql_error)): ?>
                                                                              <p class="success">✅ Connexion MySQL réussie !</p>
                                                                                    <table>
                                                                                            <tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th></tr>
                                                                                                    <?php foreach ($users as $u): ?>
                                                                                                              <tr>
                                                                                                                          <td><?= htmlspecialchars($u['id']) ?></td>
                                                                                                                                      <td><?= htmlspecialchars($u['name']) ?></td>
                                                                                                                                                  <td><?= htmlspecialchars($u['email']) ?></td>
                                                                                                                                                              <td><?= htmlspecialchars($u['role']) ?></td>
                                                                                                                                                                        </tr>
                                                                                                                                                                                <?php endforeach; ?>
                                                                                                                                                                                      </table>
                                                                                                                                                                                        <?php else: ?>
                                                                                                                                                                                              <p class="error">❌ Erreur MySQL : <?= htmlspecialchars($mysql_error) ?></p>
                                                                                                                                                                                                <?php endif; ?>

                                                                                                                                                                                                  <h2>Connexion MongoDB</h2>
                                                                                                                                                                                                    <?php if (!isset($mongo_error)): ?>
                                                                                                                                                                                                          <p class="success">✅ Connexion MongoDB réussie !</p>
                                                                                                                                                                                                                <table>
                                                                                                                                                                                                                        <tr><th>Événement</th><th>Détails</th></tr>
                                                                                                                                                                                                                                <?php foreach ($logs as $log): ?>
                                                                                                                                                                                                                                          <tr>
                                                                                                                                                                                                                                                      <td><?= htmlspecialchars($log['event'] ?? 'inconnu') ?></td>
                                                                                                                                                                                                                                                                  <td><?= htmlspecialchars(json_encode($log)) ?></td>
                                                                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                                                                                    <?php endforeach; ?>
                                                                                                                                                                                                                                                                                          </table>
                                                                                                                                                                                                                                                                                            <?php else: ?>
                                                                                                                                                                                                                                                                                                  <p class="error">❌ Erreur MongoDB : <?= htmlspecialchars($mongo_error) ?></p>
                                                                                                                                                                                                                                                                                                    <?php endif; ?>

                                                                                                                                                                                                                                                                                                      <p><strong>�� Architecture hybride validée : MySQL + MongoDB opérationnels ✅</strong></p>
                                                                                                                                                                                                                                                                                                      </body>
                                                                                                                                                                                                                                                                                                      </html>
                                                                                                                                                                                                                                                                                                      
