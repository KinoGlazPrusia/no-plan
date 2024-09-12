<?php
namespace App\Auth\Application\Exceptions;

/**
 * Clase EmailDontExistsException que se lanza cuando un correo electrónico no existe.
 */
class EmailDontExistsException extends \Exception {
    /**
     * Constructor de la clase.
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct("This email doesn't exists");
    }
}