<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *'); // pour autoriser le frontend Vercel à accéder

$response = [
    "status" => "success",
    "message" => "✅ Backend en ligne et fonctionnel via /api/test",
    "timestamp" => date('Y-m-d H:i:s'),
];

// 🔥 Envoi la réponse JSON au navigateur
echo json_encode($response);

