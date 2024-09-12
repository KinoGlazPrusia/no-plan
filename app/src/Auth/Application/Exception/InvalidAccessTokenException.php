<?php
namespace App\Auth\Application\Exception;

/**
 * Clase InvalidAccessTokenException que se lanza cuando un token de acceso es inválido.
 */
class InvalidAccessTokenException extends \Exception {
    /**
     * Constructor de la clase.
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct("Invalid access token");
    }
}