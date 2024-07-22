<?php
namespace App\Core\Infrastructure\Database;

use PDO;
use PDOException;
use App\Core\Infrastructure\Config\Env;
use App\Core\Infrastructure\Interface\ITransactionalDatabase;

class MySqlDatabase implements ITransactionalDatabase {
    
    private ?PDO $conn;

    public function connect(): bool {
        try {
            $dsn = Env::DB_TYPE . ':host=' . Env::DB_HOST . ';dbname=' . Env::DB_NAME;

            $this->conn = new PDO($dsn, Env::DB_USER, Env::DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $e) {
            fwrite(fopen('php://stdout', 'w'), $e->getMessage());
        }

        return $this->conn ? true : false;
    }

    public function prepare(string $query): Object | null {
        $stmt = null;

        try {
            $stmt = $this->conn->prepare($query);
        } 
        catch (PDOException $e) {
            fwrite(fopen('php://stdout', 'w'), $e->getMessage());
        }

        return $stmt;
    }

    public function beginTransaction(): bool {
        try {
            $this->conn->beginTransaction();
            return true;
        } 
        catch (PDOException $e) {
            fwrite(fopen('php://stdout', 'w'), $e->getMessage());
            return false;
        }
    }

    public function execute(Object $statement, array $params = []): array {
        $data = [];

        try {
            $statement->execute($params);
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $data[] = $row;
            }
        } 
        catch (PDOException $e) {
            fwrite(fopen('php://stdout', 'w'), $e->getMessage());
        }

        return $data;
    }

    public function commit(): bool {
        try {
            $this->conn->commit();
            return true;
        } 
        catch (PDOException $e) {
            fwrite(fopen('php://stdout', 'w'), $e->getMessage());
            return false;
        }
    }

    public function rollBack(): bool {
        try {
            $this->conn->rollBack();
            return true;
        } 
        catch (PDOException $e) {
            fwrite(fopen('php://stdout', 'w'), $e->getMessage());
            return false;
        }
    }

    public function getLastInsertId(): int | null {
        $lastId = null;

        try {
            $lastId = $this->conn->lastInsertId();
        } 
        catch (PDOException $e) {
            fwrite(fopen('php://stdout', 'w'), $e->getMessage());
        }

        return $lastId;
    }

    public function disconnect(): void {
        $this->conn = null;
    }
}