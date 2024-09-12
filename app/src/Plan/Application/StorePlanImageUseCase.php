<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IUseCase;

/**
 * Caso de uso para almacenar la imagen de un plan.
 */
class StorePlanImageUseCase implements IUseCase {
    /**
     * Almacena la imagen del plan en la ubicación deseada.
     *
     * @param string $src La ruta temporal donde se encuentra la imagen subida.
     * @param mixed $dst La ruta de destino donde se almacenará la imagen.
     * @return void
     * @throws \Exception Si ocurre algún error durante la operación de movimiento del archivo.
     */
    public static function store(string $src, $dst): void {
        try {
            move_uploaded_file($src, $dst);
            // [ ] Falta implementar el manejo de excepciones cuando la carpeta no tiene permisos de escritura
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }
}