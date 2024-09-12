<?php
namespace App\User\Application;

use App\Core\Infrastructure\Interface\IUseCase;

/**
 * Caso de uso para almacenar la imagen de perfil de un usuario.
 */
class StoreUserAvatarUseCase implements IUseCase {

    /**
     * Almacena una imagen de perfil en el servidor.
     *
     * @param string $src Ruta temporal del archivo de imagen en el servidor.
     * @param string $dst Ruta de destino donde se almacenará la imagen.
     * @return void
     * @throws \Exception Si ocurre un error durante el movimiento del archivo.
     */
    public static function storeAvatarImage(string $src, string $dst): void {
        try {
            move_uploaded_file($src, $dst);
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }
}
