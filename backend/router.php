<?php
// router.php — routeur universel Render pour backend PHP

// Si la requête correspond à un fichier réel (ex: image, CSS...), on le sert directement
if (php_sapi_name() === 'cli-server') {
    $file = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($file)) {
        return false;
    }
}

// Rediriger automatiquement les appels vers /api/ vers les bons fichiers
$path = trim($_SERVER['REQUEST_URI'], '/');

if ($path === '' || $path === 'index.php') {
    require __DIR__ . '/index.php';
    exit;
}

// Exemple : /api/test → /api/test.php
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

// Si rien ne correspond
http_response_code(404);
echo json_encode(["error" => "Route not found", "path" => $path]);
exit;

