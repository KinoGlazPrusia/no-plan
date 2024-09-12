<?php
namespace App\Core\Infrastructure\Interface;

/**
 * Interfaz para serializar entidades en un array asociativo.
 */
interface ISerialazible {
    /**
     * Serializa la entidad en un array asociativo.
     *
     * @param bool $includeNulls Indica si se deben incluir propiedades nulas en la serialización (por defecto true).
     * @return array Array asociativo con los campos de la tabla del modelo exclusivamente.
     */
    public function serialize(bool $includeNulls = true): array;
}
