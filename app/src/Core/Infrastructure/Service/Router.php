<?php
namespace App\Core\Infrastructure\Service;

use App\Env;
use App\Routes;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Request;
use App\Auth\Domain\JWToken;

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
        $path = rtrim($path, '/');

        // Para construir la query necesitamos métodos distintos dependiendo del request method
        // Para GET
        // Si la query está definida, la convertimos en un array asociativo
        if (isset($query)) {
            parse_str($query, $query);
        } else {
            // Para POST
            // Iteramos por el $_POST y lo guardamos en una nueva variable (array assoc.)
            $query = $_POST;
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

        // Si la ruta es privada, verificamos la cookie con JWT de acceso (autorización)
        $access = Routes::getAll()[$request->method][$request->url]['access'];

        if ($access === 'private') {
            if (!JWToken::verifyCookie()) Response::jsonError(403, "You don't have permissions");
        }
        
        // Ejecutamos el handler correspondiente a la ruta
        session_start(); // Al iniciar sesión aquí (entry) no es necesario volver a llamar a esta función
        $controller = Routes::getAll()[$request->method][$request->url]['controller'];
        $logic = Routes::getAll()[$request->method][$request->url]['logic'];
        $controller($request, $logic);
   }
}