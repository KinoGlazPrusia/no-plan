<?php
namespace App\Core\Service;

use App\Core\Config\Routes;
use App\Core\Service\Response;

class Router
{
    public static function route()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $parsed = parse_url($url);
        $parsed['path'] = $_SERVER['REQUEST_METHOD'] . $parsed['path'];
        $dst = $parsed['path'];

        if (isset($parsed['query'])) {
            parse_str($parsed['query'], $parsed['query']);
        }

        if (!Routes::routeExists($dst)) {
            Response::jsonError("error", 404, "Something went wrong with your request", "This endpoint does not exist");
        }

        Routes::getRoutes()[$dst]($parsed['query']);
    }
}