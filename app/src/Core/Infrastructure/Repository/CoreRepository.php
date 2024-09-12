<?php
namespace App\Core\Infrastructure\Repository;

use Exception;
use App\Core\Infrastructure\Database\MySqlDatabase;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IEntity;
use App\Core\Infrastructure\Interface\ITransactionalDatabase;
use App\Core\Infrastructure\Service\Response;

/**
 * Clase `CoreRepository` que implementa la interfaz `IRepository`.
 *
 * Esta clase maneja las operaciones básicas de persistencia y transacciones en la base de datos.
 */
class CoreRepository implements IRepository
{
    /**
     * @var ITransactionalDatabase El objeto de la base de datos para realizar las transacciones.
     */
    protected ITransactionalDatabase $db;

    /**
     * Constructor para inicializar el repositorio con una base de datos transaccional.
     *
     * @param ITransactionalDatabase $database La base de datos transaccional.
     */
    public function __construct(ITransactionalDatabase $database) {
        $this->db = $database;
    }

    /**
     * Guarda una entidad en la base de datos.
     *
     * @param IEntity $entity La entidad a guardar.
     * @return string Retorna el ID de la última inserción.
     * @throws Exception Si ocurre algún error durante la operación.
     */
    public function save(IEntity $entity): string {
        $data = $entity->serialize(false);
        $keys = array_keys($data);
        $placeholders = array_map(function($key) {
            return ':' . $key;
        }, $keys);

        $sql = 'INSERT INTO ' . $entity->table . ' (' . implode(', ', $keys) . ') VALUES (' . implode(', ', $placeholders) . ')';
        
        try {
            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $this->db->beginTransaction();
            $this->db->execute($stmt, $data);
            $lastId = $this->db->getLastInsertId(); // Es importante devolver el ID antes del commit porque sino devuelve 0
            $this->db->commit();
            $this->db->disconnect();
            return $lastId;
        } 
        catch (Exception $e) {
            $this->db->rollBack();
            $this->db->disconnect();
            throw $e;
        }
    }

    /**
     * Actualiza una entidad existente en la base de datos.
     *
     * @param IEntity $entity La entidad a actualizar.
     * @return bool Retorna true si la entidad fue actualizada exitosamente.
     * @throws Exception Si ocurre algún error durante la operación.
     */
    public function update(IEntity $entity): bool {
        $data = $entity->serialize(false);
        $keys = array_keys($data);
        $placeholders = array_map(function($key) {
            return ':' . $key;
        }, $keys);

        $sql = 'UPDATE ' . $entity->table . ' SET ';
        foreach ($keys as $index => $value) {
            if ($value !== 'id') {
                $sql .= $value . ' = ' . $placeholders[$index] . ', ';
            }
        }
        $sql = rtrim($sql, ', ');
        $sql .= ' WHERE id = ' . $placeholders[0];

        try {
            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $this->db->beginTransaction();
            $this->db->execute($stmt, $data);
            $lastId = $this->db->getLastInsertId(); // Es importante devolver el ID antes del commit porque sino devuelve 0
            $this->db->commit();
            $this->db->disconnect();
            return true;
        } 
        catch (Exception $e) {
            $this->db->rollBack();
            $this->db->disconnect();
            throw $e;
        }

        return true;
    }

    /**
     * Elimina una entidad de la base de datos con el ID dado.
     *
     * @param int $id El ID de la entidad a eliminar.
     * @return bool Retorna true si la entidad fue eliminada exitosamente.
     */
    public function delete(int $id): bool {
        return true;
    }

    /**
     * Elimina todas las entidades de la base de datos que cumplen con un campo y valor dados.
     *
     * @param string $table La tabla de la base de datos.
     * @param string $field El campo por el cual filtrar.
     * @param string $value El valor del campo por el cual filtrar.
     * @return bool Retorna true si las entidades fueron eliminadas exitosamente.
     * @throws Exception Si ocurre algún error durante la operación.
     */
    public function deleteWhere(string $table, string $field, string $value): bool {
        $sql = 'DELETE FROM ' . $table . ' WHERE ' . $field . ' = :value';

        try {
            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $this->db->beginTransaction();
            $res = $this->db->execute($stmt, ['value' => $value]);
            $this->db->commit();
            $this->db->disconnect();
            return true;
        } 
        catch (Exception $e) {
            $this->db->rollBack();
            $this->db->disconnect();
            throw $e;
        }
    }

    /**
     * Encuentra una entidad en la base de datos por su ID.
     *
     * @param string $table La tabla de la base de datos.
     * @param int $id El ID de la entidad a encontrar.
     * @return IEntity|null Retorna la entidad con el ID dado o null si no se pudo encontrar.
     */
    public function find(string $table, int $id): IEntity | null {
        return null;
    }

    /**
     * Retorna todas las entidades de la base de datos.
     *
     * @param string $table La tabla de la base de datos.
     * @return array Arreglo de todas las entidades en la base de datos.
     * @throws Exception Si ocurre algún error durante la operación.
     */
    public function findAll(string $table): array {
        $res = [];

        $sql = 'SELECT * FROM ' . $table;

        try {
            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $res = $this->db->execute($stmt);
            $this->db->disconnect();
            return $res;
        } 
        catch (Exception $e) {
            $this->db->disconnect();
            throw $e;
        }
        
        return [];
    }

    /**
     * Encuentra entidades en la base de datos por un campo y valor dados.
     *
     * @param string $table La tabla de la base de datos.
     * @param string $field El campo por el cual filtrar.
     * @param string $value El valor del campo por el cual filtrar.
     * @return array Arreglo de todas las entidades que cumplen con el campo y valor dados.
     * @throws Exception Si ocurre algún error durante la operación.
     */
    public function findBy(string $table, string $field, string $value): array {
        $res = [];

        $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $field . ' = :value';

        try {
            $this->db->connect();
            $stmt = $this->db->prepare($sql);
            $this->db->beginTransaction();
            $res = $this->db->execute($stmt, ['value' => $value]);
            $this->db->commit();
            $this->db->disconnect();
            return $res;
        } 
        catch (Exception $e) {
            $this->db->rollBack();
            $this->db->disconnect();
            throw $e;
        }
    }
}   