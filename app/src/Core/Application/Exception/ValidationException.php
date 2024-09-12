<?php
namespace App\Core\Application\Exception;

/**
 * Clase ValidationException que se lanza cuando ocurre un error de validación.
 */
class ValidationException extends \Exception {
    /**
     * Constructor de la clase.
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct("Validation error");
    }
}