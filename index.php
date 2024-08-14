<?php

require "router/web.php";

$config = require 'config/app.php';
$router = new Router($config);
$router->run();
