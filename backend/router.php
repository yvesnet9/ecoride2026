<?php
// router.php — routeur universel Render pour backend PHP

// 🟢 Autoriser l’accès depuis ton frontend Vercel (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Répondre immédiatement aux requêtes OPTIONS (prévol)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 🔍 Gestion du routage interne PHP
if (php_sapi_name() === 'cli-server') {
    $file = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($file)) {
        return false;
    }
}

$path = trim($_SERVER['REQUEST_URI'], '/');

// 🏠 Route par défaut
if ($path === '' || $path === 'index.php') {
    require __DIR__ . '/index.php';
    exit;
}

// 🧩 Gestion des routes API (/api/…)
if (preg_match('#^api/(.+)$#', $path, $matches)) {
    $target = __DIR__ . '/' . $matches[0] . '.php';
    if (file_exists($target)) {
        require $target;
        exit;
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Route $path not found"]);
        exit;
    }
}

// 🚫 Si rien ne correspond
http_response_code(404);
echo json_encode(["error" => "Route not found", "path" => $path]);
exit;

