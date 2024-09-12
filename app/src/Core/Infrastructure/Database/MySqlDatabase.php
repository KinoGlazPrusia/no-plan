<?php
namespace App\Core\Infrastructure\Database;

use Exception;
use PDO;
use PDOException;
use App\Env;
use App\Core\Infrastructure\Interface\ITransactionalDatabase;

/**
 * Clase MySqlDatabase que implementa la interfaz ITransactionalDatabase.
 * Maneja la conexión a la base de datos MySQL y las transacciones.
 */
class MySqlDatabase implements ITransactionalDatabase {
    
    /**
     * @var PDO|null Conexión a la base de datos.
     */
    private ?PDO $conn;

    /**
     * Conecta a la base de datos MySQL.
     *
     * @return bool Retorna true si la conexión fue exitosa, false en caso contrario.
     * @throws Exception Si ocurre un error durante la conexión.
     */
    public function connect(): bool {
        try {
            $dsn = Env::$DB_TYPE . ':host=' . Env::$DB_HOST . ';dbname=' . Env::$DB_NAME;

            $this->conn = new PDO($dsn, Env::$DB_USER, Env::$DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }

        return $this->conn ? true : false;
    }

    /**
     * Prepara una consulta SQL.
     *
     * @param string $query La consulta SQL a preparar.
     * @return Object|null La declaración preparada o null si falla.
     * @throws Exception Si ocurre un error durante la preparación de la consulta.
     */
    public function prepare(string $query): Object | null {
        $stmt = null;

        try {
            $stmt = $this->conn->prepare($query);
        } 
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }

        return $stmt;
    }

    /**
     * Inicia una transacción.
     *
     * @return bool Retorna true si la transacción fue iniciada exitosamente.
     * @throws Exception Si ocurre un error durante el inicio de la transacción.
     */
    public function beginTransaction(): bool {
        try {
            $this->conn->beginTransaction();
            return true;
        } 
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Ejecuta una declaración preparada.
     *
     * @param Object $statement La declaración preparada.
     * @param array $params Los parámetros para la declaración.
     * @return array El resultado de la consulta en forma de array.
     * @throws Exception Si ocurre un error durante la ejecución.
     */
    public function execute(Object $statement, array $params = []): array {
        $data = [];

        try {
            $statement->execute($params);
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $data[] = $row;
            }
        } 
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }

        return $data;
    }

    /**
     * Confirma una transacción.
     *
     * @return bool Retorna true si la transacción fue confirmada exitosamente.
     * @throws Exception Si ocurre un error durante la confirmación.
     */
    public function commit(): bool {
        try {
            $this->conn->commit();
            return true;
        } 
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Revierte una transacción.
     *
     * @return bool Retorna true si la transacción fue revertida exitosamente.
     * @throws Exception Si ocurre un error durante la reversión.
     */
    public function rollBack(): bool {
        try {
            $this->conn->rollBack();
            return true;
        } 
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Obtiene el último ID insertado.
     *
     * @return int|string|null El ID del último registro insertado o null si falla.
     * @throws Exception Si ocurre un error al obtener el ID.
     */
    public function getLastInsertId(): int | string | null {
        try {
            $lastId = $this->conn->lastInsertId();
            return $lastId;

        } 
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Desconecta de la base de datos.
     *
     * @return void
     */
    public function disconnect(): void {
        $this->conn = null;
    }
}