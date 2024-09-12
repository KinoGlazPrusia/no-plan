<?php
namespace App\Auth\Application\Exceptions;

/**
 * Clase InvalidCredentialsException que se lanza cuando las credenciales (correo electrónico o contraseña) no son válidas.
 */
class InvalidCredentialsException extends \Exception {
    /**
     * Constructor de la clase.
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct("Email or password are not valid");
    }
}