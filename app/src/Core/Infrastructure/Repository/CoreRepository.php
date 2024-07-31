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
    private ITransactionalDatabase $db;

    public function __construct(ITransactionalDatabase $database) {
        $this->db = $database;
    }

    public function save(IEntity $entity): bool {
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

    public function update(IEntity $entity): bool {
        return true;
    }

    public function delete(int $id): bool {
        return true;
    }

    public function find(string $table, int $id): IEntity | null {
        return null;
    }

    public function findAll(string $table): array {
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