<?php
/**
 * ========================================================
  * EcoRide 2026 - Connexion MySQL (PDO)
   * ========================================================
    * Cette configuration gère la connexion à la base SQL
     * utilisée pour les utilisateurs, rôles et trajets.
      * 
       * ⚙️ Bonne pratique :
        *  - Utilisation de PDO (sécurisé, orienté objet)
         *  - Mode d'erreur : Exception
          *  - Encodage UTF-8
           *  - Reconnexion via try/catch propre
            */

            $DB_HOST = $_ENV['MYSQL_HOST']     ?? 'localhost';
            $DB_NAME = $_ENV['MYSQL_DATABASE'] ?? 'ecoride_db';
            $DB_USER = $_ENV['MYSQL_USER']     ?? 'root';
            $DB_PASS = $_ENV['MYSQL_PASSWORD'] ?? '';

            try {
                $pdo = new PDO(
                        "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4",
                                $DB_USER,
                                        $DB_PASS,
                                                [
                                                            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Lève une exception en cas d’erreur
                                                                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Retourne les résultats en tableau associatif
                                                                                    PDO::ATTR_PERSISTENT         => false,                   // Pas de connexion persistante (plus propre en dev)
                                                                                            ]
                                                                                                );

                                                                                                    // 🔄 Message de confirmation (à désactiver en prod)
                                                                                                        // echo "✅ Connexion MySQL réussie !";

                                                                                                        } catch (PDOException $e) {
                                                                                                            http_response_code(500);
                                                                                                                die(json_encode([
                                                                                                                        "error" => "Erreur de connexion MySQL",
                                                                                                                                "message" => $e->getMessage()
                                                                                                                                    ]));
                                                                                                                                    }
                                                                                                                                    
