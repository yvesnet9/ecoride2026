<?php
// 🌱 Routeur principal universel pour Ecoride Backend (Render + local)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

// Gérer les requêtes OPTIONS (CORS preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Récupère l'URI propre
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Supprime tout ce qui précède /api/
if (preg_match('#/api/(.*)#', $request, $matches)) {
    $endpoint = trim($matches[1], '/');
    $file = __DIR__ . '/api/' . $endpoint . '.php';

    if (file_exists($file)) {
        require $file;
        exit;
    } else {
        http_response_code(404);
        echo json_encode([
            "error" => "❌ Route non trouvée",
            "recherché" => $file,
            "uri" => $request
        ]);
        exit;
    }
}

// Page d’accueil
echo json_encode([
    "status" => "success",
    "message" => "🌱 Ecoride Backend API — Online ✅",
    "routes" => ["/api/test", "/api/users", "/api/login", "/api/register"]
]);

