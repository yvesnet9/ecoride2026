<?php
require_once __DIR__ . '/config/mongo.php';

$client = getMongoConnection();
$db = $client->selectDatabase('ecoride_logs');
$collection = $db->selectCollection('logs');

$logs = [
    ['action' => 'login', 'user' => 'Admin EcoRide', 'timestamp' => new MongoDB\BSON\UTCDateTime()],
        ['action' => 'ride_created', 'user' => 'Alice Dupont', 'timestamp' => new MongoDB\BSON\UTCDateTime()],
            ['action' => 'booking_made', 'user' => 'Bob Martin', 'timestamp' => new MongoDB\BSON\UTCDateTime()],
                ['action' => 'logout', 'user' => 'Admin EcoRide', 'timestamp' => new MongoDB\BSON\UTCDateTime()],
                ];

                $result = $collection->insertMany($logs);
                echo "✅ " . $result->getInsertedCount() . " logs insérés dans MongoDB.\n";
                
