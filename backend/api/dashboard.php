<?php
/**
 * ==========================================================
  * 🌿 EcoRide - API Dashboard
   * ----------------------------------------------------------
    * Fournit les statistiques globales pour le tableau de bord
     * administrateur (React frontend).
      * 
       * Technologies : PHP + MySQL + MongoDB (logs)
        * Auteur : Yves [EcoRide Project]
         * ==========================================================
          */

          // 🔓 Autoriser l’accès CORS pour le front React
          header("Access-Control-Allow-Origin: *");
          header("Content-Type: application/json; charset=UTF-8");

          // ⚙️ Inclure la configuration MySQL et MongoDB
          require_once __DIR__ . '/../config/db_mysql.php';
          require_once __DIR__ . '/../config/mongo.php';

          // ✅ Connexion MySQL
          $pdo = getMySQLConnection();

          // ✅ Connexion MongoDB (pour logs)
          $mongoClient = getMongoConnection();
          $mongoDB = $mongoClient->selectDatabase('ecoride_logs');
          $logsCollection = $mongoDB->selectCollection('logs');

          /**
           * ==========================================================
            * 📊 1. Fonctions statistiques MySQL
             * ==========================================================
              */

              // 🔸 Nombre total de trajets
              function getRidesCount($pdo) {
                  $stmt = $pdo->query("SELECT COUNT(*) AS total FROM rides");
                      return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                      }

                      // 🔸 Nombre total de réservations (table bookings)
                      function getReservationsCount($pdo) {
                          $stmt = $pdo->query("SELECT COUNT(*) AS total FROM bookings");
                              return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                              }

                              // 🔸 Nombre de conducteurs uniques
                              function getUniqueDriversCount($pdo) {
                                  $stmt = $pdo->query("SELECT COUNT(DISTINCT driver_id) AS total FROM rides");
                                      return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                                      }

                                      // 🔸 Répartition des trajets par conducteur
                                      function getRidesByDriver($pdo) {
                                          $stmt = $pdo->query("
                                                  SELECT u.name AS name, COUNT(r.id) AS value
                                                          FROM rides r
                                                                  JOIN users u ON r.driver_id = u.id
                                                                          GROUP BY r.driver_id
                                                                              ");
                                                                                  return $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                                                  }

                                                                                  // 🔸 Répartition des trajets par date
                                                                                 
                                                                                                                              function getRidesByDate($pdo) {
                                                                                                                                  $stmt = $pdo->query("
                                                                                                                                          SELECT DATE(departure_time) AS date, COUNT(*) AS count
                                                                                                                                                  FROM rides
                                                                                                                                                          GROUP BY DATE(departure_time)
                                                                                                                                                                  ORDER BY DATE(departure_time) ASC
                                                                                                                                                                      ");
                                                                                                                                                                          return $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                                                                                                                                          }
                                                                                                                                                                          

                                                                                                                              // 🔸 Nombre total de véhicules
                                                                                                                              function getVehiclesCount($pdo) {
                                                                                                                                  $stmt = $pdo->query("SELECT COUNT(*) AS total FROM vehicles");
                                                                                                                                      return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                                                                                                                                      }

                                                                                                                                      /**
                                                                                                                                       * ==========================================================
                                                                                                                                        * 🧾 2. Statistiques MongoDB (logs)
                                                                                                                                         * ==========================================================
                                                                                                                                          */

                                                                                                                                          // 🔸 Nombre total d’entrées de logs
                                                                                                                                          function getLogsCount($logsCollection) {
                                                                                                                                              return $logsCollection->countDocuments();
                                                                                                                                              }

                                                                                                                                              /**
                                                                                                                                               * ==========================================================
                                                                                                                                                * 🚀 3. Réponse JSON
                                                                                                                                                 * ==========================================================
                                                                                                                                                  */

                                                                                                                                                  try {
                                                                                                                                                      $data = [
                                                                                                                                                              "totalRides"         => getRidesCount($pdo),
                                                                                                                                                                      "totalReservations"  => getReservationsCount($pdo),
                                                                                                                                                                              "uniqueDrivers"      => getUniqueDriversCount($pdo),
                                                                                                                                                                                      "ridesByDriver"      => getRidesByDriver($pdo),
                                                                                                                                                                                              "ridesByDate"        => getRidesByDate($pdo),
                                                                                                                                                                                                      "vehiclesCount"      => getVehiclesCount($pdo),
                                                                                                                                                                                                              "logsCount"          => getLogsCount($logsCollection)
                                                                                                                                                                                                                  ];

                                                                                                                                                                                                                      echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                                                                                                                                                                                                                      } catch (Exception $e) {
                                                                                                                                                                                                                          echo json_encode(["error" => $e->getMessage()]);
                                                                                                                                                                                                                          }
                                                                                                                                                                                                                          
