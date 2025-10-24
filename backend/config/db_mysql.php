<?php
/**
 * ==========================================================
  * ⚙️ EcoRide - Configuration MySQL
   * ----------------------------------------------------------
    * Fournit la fonction getMySQLConnection()
     * utilisée dans les API du backend (ex: dashboard.php)
      * ==========================================================
       */

       function getMySQLConnection() {
           $host = 'localhost';
               $dbname = 'ecoride_db';
                   $username = 'root';
                       $password = 'root123'; // 🔑 Mets ici ton mot de passe MySQL s’il y en a un

                           try {
                                   $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                                           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                   return $pdo;
                                                       } catch (PDOException $e) {
                                                               die(json_encode(["error" => "Erreur de connexion MySQL: " . $e->getMessage()]));
                                                                   }
                                                                   }
                                                                   
