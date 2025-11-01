<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *'); // pour autoriser le frontend Vercel à accéder

$response = [
    "status" => "success",
    "message" => "✅ Backend en ligne et fonctionnel via /api/test",
    "timestamp" => date('Y-m-d H:i:s'),
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>

