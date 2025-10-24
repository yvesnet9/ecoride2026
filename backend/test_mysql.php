<?php
require_once 'config/db.php';

try {
    $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll();

            echo "✅ Connexion réussie à la base de données !<br>";
                echo "📋 Tables disponibles :<br>";

                    foreach ($tables as $table) {
                            echo "- " . $table['Tables_in_ecoride_db'] . "<br>";
                                }
                                } catch (PDOException $e) {
                                    echo "❌ Erreur lors de la récupération des tables : " . $e->getMessage();
                                    }
                                    ?>
                                    
