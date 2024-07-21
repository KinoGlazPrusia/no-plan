<?php
namespace App\Core\Domain;

use App\Core\Infrastructure\Interface\IEntity;
use App\Core\Infrastructure\Interface\ISerialazible;

/**
 * Clase base para todas las entidades del dominio. Implementa las interfaces IEntity y ISerialazible.
 */
class CoreEntity implements IEntity, ISerialazible {
    /**
     * @var string Nombre de la tabla en la base de datos.
     */
    protected string $table;

    /**
     * @var array Columnas de la tabla o atributos de la entidad.
     */
    protected array $columns;

    /**
     * Constructor para inicializar la entidad con el nombre de la tabla y las columnas.
     *
     * @param string $table Nombre de la tabla en la base de datos.
     * @param array $columns Columnas de la tabla o atributos de la entidad.
     */
    public function __construct(string $table, array $columns) {
        $this->table = $table;
        $this->columns = $columns;
    }

    /**
     * Serializa la entidad en un array.
     *
     * @param bool $includeNulls Indica si se deben incluir propiedades nulas en la serialización (por defecto true).
     * @return array Array que representa la entidad serializada.
     */
    public function serialize(bool $includeNulls = true): array {
        $map = array();

        // Recorremos cada columna y la agregamos al array si cumple con las condiciones
        foreach($this->columns as $column) {
            // No incluir propiedades nulas si 'includeNulls' es false
            if (!$includeNulls && !$this->{$column}) continue;

            // Añadir la propiedad al array
            $map[$column] = $this->{$column};
        }

        // Devolver el array serializado
        return $map;
    }
}