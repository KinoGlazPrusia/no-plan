<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Infrastructure\Service\Router;
use App\Auth\Domain\JWToken;

$request = Router::parse();
Router::handle($request);