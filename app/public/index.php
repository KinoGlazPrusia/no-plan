<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Env;
use App\Core\Infrastructure\Service\Router;

if (Env::STATUS === 'dev') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$request = Router::parse();
Router::handle($request);