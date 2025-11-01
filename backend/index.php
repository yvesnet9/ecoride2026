<?php
// ✅ Routeur principal pour le backend Ecoride
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

$request = $_SERVER['REQUEST_URI'];

// Supprime les éventuels paramètres de requête (?foo=bar)
$request = strtok($request, '?');

// Si l’URL commence par /api/, on cherche le fichier correspondant
if (strpos($request, '/api/') === 0) {
    $path = __DIR__ . $request . '.php';
    if (file_exists($path)) {
        require $path;
        exit;
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Route non trouvée: $request"]);
        exit;
    }
}

// Par défaut : message d’accueil
echo json_encode([
    "status" => "success",
    "message" => "🌱 Ecoride Backend API — Online ✅",
    "routes" => ["/api/test", "/api/users", "/api/login", "/api/register"]
]);

