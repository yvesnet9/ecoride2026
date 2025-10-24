<?php
// ====================================================
// 🌿 Fichier : backend/config/db.php
// Rôle : Connexion MySQL (pour API EcoRide)
// ====================================================

$host = 'localhost';
$dbname = 'ecoride_db';
$username = 'ecoride_user';
$password = 'ecoride123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
            
