$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($request, '/api/') === 0) {
    $endpoint = substr($request, 5);
    $path = __DIR__ . '/api/' . $endpoint . '.php';

