<?php
// 🌍 backend/router.php — Routeur principal universel pour Render & Vercel

// 🔐 CORS pour autoriser ton frontend React (Vercel) à communiquer
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// ⚡ Réponse immédiate aux requêtes prévol (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 📦 Déterminer l’URI demandée
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/'); // Nettoyage
$root = __DIR__;

// 🔎 Si c’est la racine → afficher un message de bienvenue
if ($uri === '' || $uri === '/' || $uri === '/index.php') {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "success",
        "message" => "🌱 Ecoride Backend API — Online ✅",
        "routes" => [
            "/api/test",
            "/api/test_pg.php",
            "/api/login",
            "/api/register",
            "/api/users"
        ]
    ]);
    exit;
}

// 🧩 Routes de l’API : /api/<nom>.php
if (preg_match('#^/api/(.+)$#', $uri, $matches)) {
    $route = $matches[1];

    // Exemple : /api/test → backend/api/test.php
    $path = $root . "/api/" . $route;

    // Si le fichier existe → on l’exécute
    if (is_file($path)) {
        require $path;
        exit;
    } else {
        // 🔴 Route non trouvée → réponse JSON explicite
        header('Content-Type: application/json');
        echo json_encode([
            "error" => "Route $route not found",
            "available_routes" => array_map(
                fn($f) => "/api/" . basename($f),
                glob($root . "/api/*.php")
            )
        ]);
        exit;
    }
}

// 🪶 Si rien ne correspond → message 404
http_response_code(404);
header('Content-Type: application/json');
echo json_encode([
    "error" => "404 Not Found",
    "path" => $uri
]);

