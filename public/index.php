<?php

require_once __DIR__ . '/../vendor/autoload.php';
use app\App\core\Application;

session_start();

$app = new Application(dirname(__DIR__));

$app->run();