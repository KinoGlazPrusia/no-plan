<?php
namespace App\Core\Infrastructure\Service;

use App\Core\Infrastructure\Config\Env;
use App\Core\Infrastructure\Config\Routes;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Request;

/**
 * Clase Router responsable de analizar y manejar las solicitudes HTTP.
 */
class Router
{
    /**
     * Analiza la solicitud HTTP y devuelve una instancia de Request.
     *
     * @return Request Instancia de la solicitud HTTP analizada.
     */
   public static function parse(): Request {
        // Construimos la URL completa de la solicitud
        $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        // Obtenemos el método HTTP (GET, POST, etc.)
        $method = $_SERVER['REQUEST_METHOD'];

        // Obtenemos el path de la URL
        $path =  parse_url($url, PHP_URL_PATH);

        // Obtenemos los parámetros de la query de la URL
        $query = parse_url($url, PHP_URL_QUERY);

        // Eliminamos la parte del directorio público del path
        $path = substr($path, strlen(Env::PUBLIC_DIR) + 1);

        // Si la query está definida, la convertimos en un array asociativo
        if (isset($query)) {
            parse_str($query, $query);
        }

        // Devolvemos una nueva instancia de Request con el método, path y query
        return new Request($method, $path, $query);
   }

    /**
     * Maneja la solicitud HTTP usando la información de la instancia Request.
     *
     * @param Request $request Instancia de la solicitud HTTP.
     * @return void
     */
   public static function handle(Request $request): void {
        // Verificamos si la ruta existe para el método y el path dado
        if (!Routes::routeExists($request->method, $request->url)) {
            // Si la ruta no existe, devolvemos un error 404
            Response::jsonError(404, "This page does not exist");
        };
        
        // Ejecutamos el handler correspondiente a la ruta
        Routes::getAll()[$request->method][$request->url]($request);
   }
}