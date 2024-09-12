<?php 
namespace App\Core\Infrastructure\Interface;

/**
 * Interface IEntity.
 *
 * Define el método para serializar una entidad.
 */
interface IEntity {
    /**
     * Serializa la entidad en un array.
     *
     * @param bool $includeNulls Indica si se deben incluir propiedades nulas en la serialización (por defecto true).
     * @return array Array que representa la entidad serializada.
     */
    public function serialize(bool $includeNulls = true): array;
}