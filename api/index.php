<?php
// Forward Vercel requests to the correct local file
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Serve static files as they are
if ($uri !== '/' && file_exists(__DIR__ . '/../' . $uri)) {
    return false;
}

// Redirect base path to the main app index
if ($uri === '/' || $uri === '/index.php') {
    require __DIR__ . '/../index.php';
    exit;
}

// Check if a specific PHP file is requested
$file = __DIR__ . '/..' . $uri;
if (file_exists($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
    require $file;
    exit;
}

// Handle query parameter edge cases automatically (e.g. /jobs.php?filter=dev)
$req = explode('?', $uri)[0];
if (file_exists(__DIR__ . '/..' . $req)) {
   require __DIR__ . '/..' . $req;
   exit;
}

// Fallback to 404
http_response_code(404);
require __DIR__ . '/../not-found.php';
?>
