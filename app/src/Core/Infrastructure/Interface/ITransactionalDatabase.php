<?php 
namespace App\Core\Infrastructure\Interface;

/**
 * Interfaz para manejo de conexiones y transacciones en una base de datos.
 */
interface ITransactionalDatabase
{   
    /**
     * Conecta a la base de datos.
     *
     * @return bool Retorna true si se pudo conectar con la base de datos.
     */
    public function connect(): bool;      
    
    /**
     * Prepara una consulta SQL.
     *
     * @param string $query La consulta SQL a preparar.
     * @return object|null Retorna un statement (objeto) o null si no se pudo preparar la consulta.
     */
    public function prepare(string $query): Object | null;    
    
    /**
     * Inicia una transacción.
     *
     * @return bool Retorna true si se pudo iniciar una transacción.
     */
    public function beginTransaction(): bool;
    
    /**
     * Ejecuta una consulta preparada.
     *
     * @param object $statement El objeto statement preparado.
     * @param array $params Parámetros a ligar a la consulta preparada (por defecto es un array vacío).
     * @return array Retorna un array de objetos con los resultados de la ejecución de la consulta.
     */
    public function execute(Object $statement, array $params = []): array;

    /**
     * Confirma una transacción.
     *
     * @return bool Retorna true si se pudo realizar la transacción.
     */
    public function commit(): bool;

    /**
     * Revierte una transacción.
     *
     * @return bool Retorna true si se pudo revertir la transacción.
     */
    public function rollBack(): bool;

    /**
     * Obtiene el ID de la última inserción.
     *
     * @return int Retorna el ID de la última fila insertada.
     */
    public function getLastInsertId(): int | null;

    /**
     * Desconecta la base de datos.
     *
     * @return void
     */
    public function disconnect(): void;
}