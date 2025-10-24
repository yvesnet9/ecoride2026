<?php
/**
 * ==========================================================
  * 🗄️ EcoRide - Configuration MongoDB
   * ----------------------------------------------------------
    * Fournit la fonction getMongoConnection()
     * utilisée dans dashboard.php pour les logs système
      * ==========================================================
       */

      require_once __DIR__ . '/../vendor/autoload.php';
       // charge le driver MongoDB

       use MongoDB\Client;

       function getMongoConnection() {
           try {
                   // ⚙️ URI par défaut (à adapter si ton MongoDB a un mot de passe)
                           $uri = "mongodb://localhost:27017";

                                   // ✅ Connexion
                                           $client = new Client($uri);

                                                   return $client;
                                                       } catch (Exception $e) {
                                                               die(json_encode(["error" => "Erreur de connexion MongoDB: " . $e->getMessage()]));
                                                                   }
                                                                   }
                                                                   
