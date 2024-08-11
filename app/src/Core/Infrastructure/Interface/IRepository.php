<?php 
namespace App\Core\Infrastructure\Interface;

use Exception;
use App\Core\Infrastructure\Interface\IEntity;

/**
 * Interfaz para el repositorio que maneja operaciones básicas de persistencia.
 */
interface IRepository
{
    /**
     * Guarda una entidad en la base de datos.
     *
     * @param IEntity $entity La entidad a guardar.
     * @return bool Retorna true si se pudo guardar el modelo en la base de datos.
     */
    public function save(IEntity $entity): string;   
    
    /**
     * Actualiza una entidad existente en la base de datos.
     *
     * @param IEntity $entity La entidad a actualizar.
     * @return bool Retorna true si se pudo actualizar el modelo en la base de datos (si existe).
     */
    public function update(IEntity $entity): bool;     

    /**
     * Elimina una entidad de la base de datos con el ID dado.
     *
     * @param int $id El ID de la entidad a eliminar.
     * @return bool Retorna true si se pudo eliminar el modelo de la base de datos con el id dado.
     */
    public function delete(int $id): bool;  

    /**
     * Elimina todas las entidades de la base de datos que cumplen con un campo y valor dados.
     *
     * @param string $field El campo por el cual filtrar.
     * @param string $value El valor del campo por el cual filtrar.
     * @return bool Retorna true si se pudo eliminar el modelo de la base de datos con el id dado.
     */
    public function deleteWhere(string $table, string $field, string $value): bool;
    
    /**
     * Encuentra una entidad en la base de datos por su ID.
     *
     * @param int $id El ID de la entidad a encontrar.
     * @return IEntity|null Retorna el modelo con el id dado o null si no se pudo encontrar.
     */
    public function find(string $table, int $id): IEntity | null;
    
    /**
     * Retorna todas las entidades en la base de datos.
     *
     * @return array Arreglo de todas las entidades en la base de datos.
     */
    public function findAll(string $table): array;    
    
    /**
     * Encuentra entidades en la base de datos por un campo y valor dados.
     *
     * @param string $field El campo por el cual filtrar.
     * @param string $value El valor del campo por el cual filtrar.
     * @return array Arreglo de todas las entidades que cumplen con el campo y valor dados.
     */
    public function findBy(string $table, string $field, string $value): array;
}