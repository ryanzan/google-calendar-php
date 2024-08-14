<?php
require "vendor/autoload.php";
require "services/google-client.php";
require "controller/event-controller.php";

class Router
{
    private $config;
    private $controller;
    private $basePath;
    const ROUTER_LIST = ['/index.php', '/events.php', '/create.php', '/delete.php', '/signout.php'];

    public function __construct($config)
    {
        $this->config = $config;
        $this->basePath = $this->config['basePath'];
        $this->initialize();
    }

    private function initialize()
    {
        session_start();
        $path = $this->getPath();
        if (!in_array($path, self::ROUTER_LIST)) {
            echo "Not Found";
            exit();
        }

        $client = new GoogleClient(new Google_Client(), $this->config);
        $client->initialize();
        $this->controller = new EventController($client);
    }

    public function run()
    {
        $path = $this->getPath();
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($path) {
            case "/index.php":
                $this->controller->getIndex();
                break;
            case "/create.php":
                if ($method == 'GET')
                    $this->controller->createEvent();
                if($method == 'POST') {
                    $data = $_POST;
                    $this->controller->storeEvent($data);
                }
                break;
            case "/delete.php":
                $id = $_GET['id'] ?? null;
                $this->controller->deleteEvent($id);
                break;
            case "/signout.php":
                session_destroy();
                header('Location: index.php');
                break;
            default:
                echo "Not Found";
                break;
        }
    }

    private function getPath()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (strpos($path, $this->basePath) === 0) {
            $path = substr($path, strlen($this->basePath));
        }
        return $path;
    }
}
