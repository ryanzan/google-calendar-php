<?php
require "vendor/autoload.php";
require "services/google-client.php";
require "controller/event-list-controller.php";
class Router {
    private $config;
    private $controller;
    private $basePath = '/intuji-assignment';
    const ROUTER_LIST = ['/index.php', '/events.php'];

    public function __construct($config) {
        $this->config = $config;
        $this->initialize();
    }

    private function initialize() {
        session_start();
        $path = $this->getPath();
        if (!in_array($path, self::ROUTER_LIST)) {
            echo "Not Found";
            exit();
        }

        $client = new GoogleClient(new Google_Client(), $this->config);
        $client->initialize();
        $this->controller = new EventListController($client);
    }

    public function run() {
        $path = $this->getPath();
        switch ($path) {
            case "/index.php":
                $this->controller->getIndex();
                break;
            default:
                echo "Not Found";
                break;
        }
    }

    private function getPath() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (strpos($path, $this->basePath) === 0) {
            $path = substr($path, strlen($this->basePath));
        }
        return $path;
    }
}
