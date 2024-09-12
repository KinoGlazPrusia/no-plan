<?php
namespace App\Auth\Application;

use Exception;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

/**
 * Caso de uso para verificar si un correo electrónico existe en el repositorio.
 */
class EmailExistsUseCase implements IUseCase {
    /**
     * @var IRepository El repositorio para acceder a los datos de usuario.
     */
    private IRepository $repository;

    /**
     * Constructor de la clase.
     *
     * @param IRepository $repository El repositorio para acceder a los datos de usuario.
     */
    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Verifica si un correo electrónico existe en el repositorio.
     *
     * @param string $email El correo electrónico a verificar.
     * @return bool Retorna true si el correo electrónico existe, false en caso contrario.
     * @throws Exception Si ocurre algún error durante la verificación.
     */
    public function __invoke($email): bool {
        try {
            $res = $this->repository->findBy('user', 'email', $email);
            if (count($res) > 0) {
                return true;
            }
        } 
        catch (Exception $e) {
            throw $e;
        }

        return false;
    }
}