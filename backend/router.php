<?php
// router.php — Routeur universel Render pour backend PHP

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 🔍 Récupérer le chemin demandé
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($uri, '/');

// 🧭 Router les requêtes API
if (preg_match('/^api\//', $path)) {
    $apiPath = __DIR__ . '/' . $path;

    // ✅ Si le fichier existe, on l’inclut
    if (file_exists($apiPath)) {
        require $apiPath;
    } else {
        // 🚀 Liste des routes disponibles pour debug
        $routes = [];
        foreach (glob(__DIR__ . '/api/*.php') as $file) {
            $routes[] = str_replace(__DIR__, '', $file);
            $routes = array_map(fn($r) => str_replace('/api', '/api', $r), $routes);
        }

        echo json_encode([
            "error" => "Route {$path} not found",
            "available_routes" => [
                "/api/test",
                "/api/test_pg.php",
                "/api/login",
                "/api/register",
                "/api/users"
            ]
        ]);
    }
} else {
    // 🌱 Page d’accueil par défaut
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
}

