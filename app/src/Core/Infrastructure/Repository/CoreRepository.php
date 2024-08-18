<?php
namespace App\Core\Infrastructure\Repository;

use Exception;
use App\Core\Infrastructure\Database\MySqlDatabase;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IEntity;
use App\Core\Infrastructure\Interface\ITransactionalDatabase;
use App\Core\Infrastructure\Service\Response;

class CoreRepository implements IRepository
{
    protected ITransactionalDatabase $db;

    public function __construct(ITransactionalDatabase $database) {
        $this->db = $database;
    }

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

    public function update(IEntity $entity): bool {
        $data = $entity->serialize(false);
        $keys = array_keys($data);
        $placeholders = array_map(function($key) {
            return ':' . $key;
        }, $keys);

        /* print_r($data);
        print_r($keys);
        print_r($placeholders); */

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

    public function delete(int $id): bool {
        return true;
    }

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

    public function find(string $table, int $id): IEntity | null {
        return null;
    }

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