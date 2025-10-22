<?php
require 'config/db_mysql.php';

$db = new MySQLConnection();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT NOW() as current_time");
$result = $stmt->fetch();

echo "🕒 MySQL fonctionne, l'heure actuelle du serveur est : " . $result['current_time'] . "\n";

