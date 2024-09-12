<?php
namespace App\Core\Application\Exception;

/**
 * Clase ResourceNotFoundException que se lanza cuando no se encuentra un recurso solicitado.
 */
class ResourceNotFoundException extends \Exception {
    /**
     * Constructor de la clase.
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct("Resource not found");
    }
}