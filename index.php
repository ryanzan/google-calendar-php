
<?php
require "vendor/autoload.php";
require "services/google-client.php";
require "controller/event-list-controller.php";
$config = require 'config.php';
session_start();

const routerList = ['/index.php', '/events.php'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/intuji-assignment';
if (strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
}
if (!in_array($path, routerList)) {
    echo "Not Found";
    exit();
}
$client = new GoogleClient(new Google_Client(), $config);
if (!isset($_SESSION['access_token'])) {
    $authUrl = $client->getAuthUrl();
    echo $authUrl;
    exit();
}
try {
    $token = $_SESSION['access_token'];
    $client->setAccessToken($token);
    $userInfo = $client->getClientId($token);
} catch (Exception $e) {
    $authUrl = $client->getAuthUrl();
    echo $authUrl;
}
$controller = new EventListController($client);
switch ($path) {
    case "/index.php":
        $controller->getIndex();
        break;
    default:
        echo "Not Found";
        break;
}

