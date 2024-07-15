<?php
namespace App\Core\Config;

use App\Core\Config\Env;

class Routes
{
    public static function routeExists(string $route) {
        $routes = array_keys(self::getRoutes());
        return in_array($route, $routes) ? true : false;
    } 

    public static function getRoutes() {
        return [
            'GET/' . Env::ROOT . 'home' => [Env::class, 'test'],
            'GET/' . Env::ROOT . 'about' => [Env::class, 'test'],
        ];
    }
}