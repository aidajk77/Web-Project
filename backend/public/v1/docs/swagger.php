<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../../../vendor/autoload.php';

if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
   define('BASE_URL', 'http://localhost/web-project/backend');
} else {
   define('BASE_URL', 'https://add-production-server-after-deployment/backend/');
}

$openapi = \OpenApi\Generator::scan([
   __DIR__ . '/doc_setup.php',
   __DIR__ . '/../../../rest/routes'
]);

// 🔁 Inject correct base URL for Swagger to hit your routes
$openapiArray = json_decode($openapi->toJson(), true);
$openapiArray['servers'] = [
    [
        'url' => BASE_URL . '/index.php',
        'description' => 'Local API with index.php'
    ]
];

header('Content-Type: application/json');
echo json_encode($openapiArray, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
