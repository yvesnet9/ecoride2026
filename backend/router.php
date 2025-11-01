<?php
// router.php — routeur universel Render pour backend PHP

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Répondre immédiatement aux requêtes OPTIONS (pré-vol CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, "/");

// 🔎 Gestion des routes API
if (strpos($uri, "api/") === 0) {
    $route = str_replace("api/", "", $uri);

    $file = __DIR__ . "/api/" . $route . ".php";

    if (file_exists($file)) {
        require $file;
    } else {
        http_response_code(404);
        echo json_encode([
            "error" => "Route $route not found",
            "available_routes" => [
                "/api/test",
                "/api/users",
                "/api/login",
                "/api/register"
            ]
        ]);
    }
    exit;
}

// Page d’accueil du backend
header("Content-Type: application/json; charset=utf-8");
echo json_encode([
    "status" => "success",
    "message" => "🌱 Ecoride Backend API — Online ✅",
    "routes" => [
        "/api/test",
        "/api/users",
        "/api/login",
        "/api/register"
    ]
]);

