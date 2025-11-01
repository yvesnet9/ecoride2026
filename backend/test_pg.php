<?php
// backend/test_pg.php

require_once __DIR__ . '/config/config.php';

try {
    $stmt = $pdo->query("
        SELECT table_name 
        FROM information_schema.tables
        WHERE table_schema = 'public'
        ORDER BY table_name;
    ");
    
    $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>✅ Connexion réussie à la base PostgreSQL !</h2>";
    echo "<h3>📋 Tables disponibles :</h3>";

    if (empty($tables)) {
        echo "Aucune table trouvée dans le schéma public.<br>";
    } else {
        foreach ($tables as $table) {
            echo "- " . htmlspecialchars($table['table_name']) . "<br>";
        }
    }
} catch (PDOException $e) {
    echo "❌ Erreur : " . htmlspecialchars($e->getMessage());
}
?>
