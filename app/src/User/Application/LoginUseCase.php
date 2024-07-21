<?php 
namespace App\User\Application;

use App\Core\Infrastructure\Interface\IUseCase;

class LoginUseCase implements IUseCase {
    public function __invoke(): string {
        return 'Login Use Case Invoked!';
    }
}