<?php

require "router/web.php";

$config = require 'config.php';
$router = new Router($config);
$router->run();
