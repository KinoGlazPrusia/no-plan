<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Infrastructure\Service\Router;

$request = Router::parse();
Router::handle($request);