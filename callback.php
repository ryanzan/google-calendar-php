<?php
require 'vendor/autoload.php';
require 'services/google-client.php';
$config = require 'config.php';

session_start();
$client = new GoogleClient(new Google_Client(), $config);

if (!isset($_GET['code'])) {
    header('Location: index.php');
    exit();
}
$token = $client->fetchAccessToken($_GET['code']);
$_SESSION['access_token'] = $token;
header('Location: index.php');
?>