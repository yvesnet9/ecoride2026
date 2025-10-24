<?php
/**
 * ==============================================================
  *  FICHIER : mongo_demo.php
   *  POSITION : backend/
    *  RÔLE     : Lire et afficher le contenu des collections MongoDB
     * ==============================================================
      */

      require_once __DIR__ . '/config/mongo.php'; // Connexion MongoDB via mongo.php

      echo "\n🌿 ===== DEMONSTRATION MongoDB EcoRide ===== 🌿\n\n";

      // 1️⃣ Affichage des collections existantes
      $collections = $dbMongo->listCollections();
      echo "📦 Collections disponibles :\n";
      foreach ($collections as $collection) {
          echo "- " . $collection->getName() . "\n";
          }

          // Fonction d’affichage simplifiée d’une collection
          function afficherCollection($dbMongo, $nom) {
              echo "\n➡️  Données de la collection : $nom\n";
                  $cursor = $dbMongo->$nom->find();
                      foreach ($cursor as $document) {
                              print_r($document);
                                  }
                                  }

                                  // 2️⃣ Lecture et affichage des données
                                  afficherCollection($dbMongo, "analytics");
                                  afficherCollection($dbMongo, "logs");
                                  afficherCollection($dbMongo, "locations");
                                  afficherCollection($dbMongo, "sessions");

                                  echo "\n✅ Fin de la démonstration MongoDB EcoRide ✅\n";
                                  ?>
                                  
