<?php
namespace App\Core\Infrastructure\Service;

/**
 * Clase que representa una solicitud HTTP.
 */
class Request
{
    /**
     * El método HTTP utilizado en la solicitud (GET, POST, etc.).
     * 
     * @var string
     */
    public readonly string $method;

    /**
     * La URL de la solicitud.
     * 
     * @var string
     */
    public readonly string $url;

    /**
     * Los parámetros de consulta de la solicitud.
     * 
     * @var array|null
     */
    public readonly array | null $query;


    /**
     * Constructor para inicializar la solicitud HTTP.
     *
     * @param string $method El método HTTP utilizado en la solicitud.
     * @param string $url La URL de la solicitud.
     * @param array|null $query Los parámetros de consulta de la solicitud.
     */
    public function __construct(string $method, string $url, array | null $query = null)
    {
        $this->method = $method;
        $this->url = $url;
        $this->query = $query;
    }

    /**
     * Valida la consulta en función de una consulta esperada.
     *
     * @param array|null $expectedQuery Una lista de claves esperadas en la consulta.
     * @return bool Retorna true si la consulta es válida, false en caso contrario.
     */
    public function validateQuery (array | null $expectedQuery = null): bool {
        $validity = true;

        // Comprobamos si los tipos de consultas coinciden (por si es nulo)
        if (gettype($this->query) !== gettype($expectedQuery)) $validity = false;

        // Si hay una consulta esperada, validamos cada clave
        if ($expectedQuery && $this->query) {
            foreach ($expectedQuery as $key) {

                // Verificamos si la clave existe en la consulta proporcionada (solo en el caso de GET)
                if (!array_key_exists($key, $this->query)) $validity = false;

                // Validamos la consulta en función del método HTTP
                switch ($this->method) {
                    case 'GET':
                        if (!isset($_GET[$key])) $validity = false;
                        break;
                    case 'POST':
                        if (!isset($_POST[$key])) $validity = false;
                        break;
                    /* case 'PUT':
                        if (!isset($_PUT[$key])) $validity = false;
                        break;
                    case 'DELETE':
                        if (!isset($_DELETE[$key])) $validity = false;
                        break; */
                }
            }
        }

        return $validity;
    }
}