<?php
namespace App\Auth\Domain;

use Ramsey\Uuid\Uuid;

/**
 * Clase para generar UUID versión 4.
 * 
 * Value object para manejar la generación de UUIDv4.
 */
class UUIDv4 {
    
    /**
     * Genera un UUID versión 4.
     *
     * @return string El UUID generado en formato de cadena.
     */
    public static function get(): string {
        return Uuid::uuid4()->toString();
    }
}
