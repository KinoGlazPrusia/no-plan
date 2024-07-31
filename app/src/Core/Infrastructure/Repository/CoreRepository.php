<?php
namespace App\Core\Infrastructure\Repository;

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
        $this->db->connect();
        $error = false;

        $data = $entity->serialize(false);
        $keys = array_keys($data);
        $placeholders = array_map(function($key) {
            return ':' . $key;
        }, $keys);

        $sql = 'INSERT INTO ' . $entity->table . ' (' . implode(', ', $keys) . ') VALUES (' . implode(', ', $placeholders) . ')';
        $stmt = $this->db->prepare($sql);

        $this->db->beginTransaction();
        $this->db->execute($stmt, $data);
        if (!$this->db->commit()) {
            $this->db->rollBack();
            $error = true;
        }

        $this->db->disconnect();

        return !$error;
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
        $this->db->connect();
        
        $res = [];

        $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $field . ' = :value';
        $stmt = $this->db->prepare($sql);

        $this->db->beginTransaction();
        $res = $this->db->execute($stmt, ['value' => $value]);
        if (!$this->db->commit()) {
            $this->db->rollBack();
        }

        $this->db->disconnect();
        return $res;
    }
}   