<?php
namespace App\Auth\Application;

use App\User\Domain\User;
use App\Core\Infrastructure\Service\Helper;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

class GetLoggedUserFilteredDataUseCase implements IUseCase {
    private IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(): User {
        try {
            $userData = $this->repository->findBy('user', 'id', $_SESSION['uid'])[0];
            $filteredUserData = Helper::filterSensitiveData([
                'password',
                'created_at',
                'updated_at'
            ], (array)$userData);
            $user = new User((object)$filteredUserData);

            return $user;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }
}