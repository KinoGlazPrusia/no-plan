<?php
namespace App\User\Application;

use Exception;
use App\User\Domain\User;
use App\Auth\Domain\UUIDv4;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

/**
 * Caso de uso para guardar un nuevo usuario.
 */
class SaveNewUserUseCase implements IUseCase {
    
    /**
     * Guarda un nuevo usuario en el repositorio.
     *
     * @param IRepository $repository Repositorio para realizar operaciones de almacenamiento de usuario.
     * @param string $email Correo electrónico del nuevo usuario.
     * @param string $name Nombre del nuevo usuario.
     * @param string $lastname Apellido del nuevo usuario.
     * @param string $password Contraseña del nuevo usuario.
     * @param string $birth_date Fecha de nacimiento del nuevo usuario.
     * @param string $genre Género del nuevo usuario.
     * @param array $image Información de la imagen del perfil del usuario.
     * @return User El objeto del nuevo usuario creado.
     * @throws Exception Si el correo electrónico ya existe o ocurre un error durante el proceso.
     */
    public static function save (
        IRepository $repository,
        string $email,
        string $name,
        string $lastname,
        string $password,
        string $birth_date,
        string $genre,
        array $image
    ): User {
        // Revisamos si el usuario ya existe
        try {
            $res = $repository->findBy('user', 'email', $email);
            if (count($res) > 0) {
                throw new Exception('This email already exists');
            }
        } catch (Exception $e) {
            throw $e;
        }

        $uuid = UUIDv4::get();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $profile_img_url = self::generateImagePath($image);

        $data = (object)[
            'id' => $uuid,
            'name' => $name,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $hash,
            'birth_date' => $birth_date,
            'genre' => $genre,
            'profile_img_url' => $profile_img_url
        ];

        $newUser = new User($data);

        try {
            $repository->save(new User($data));
        } catch (Exception $e) {
            throw $e;
        }

        return $newUser;
    }

    /**
     * Genera la ruta para guardar la imagen del perfil del usuario.
     *
     * @param array $image Información de la imagen.
     * @return string La ruta generada para la imagen.
     */
    private static function generateImagePath(array $image): string {
        // Extraemos los datos de la imagen y la preparamos para guardarla en servidor una vez creado el usuario
        $extension = explode('/', $image['type'])[1];
        return 'assets/images/avatar/' . time() . random_int(0, 1000) . '.' . $extension;
    }
}
