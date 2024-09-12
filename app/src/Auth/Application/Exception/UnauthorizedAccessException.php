<?php
namespace App\Auth\Application\Exception;

/**
 * Clase UnauthorizedAccessException que se lanza cuando se intenta acceder sin autorización.
 */
class UnauthorizedAccessException extends \Exception {
    /**
     * Constructor de la clase.
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct("Unauthorized access");
    }
}