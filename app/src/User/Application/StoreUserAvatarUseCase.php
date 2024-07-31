<?php
namespace App\User\Application;

use Exception;
use App\User\Domain\User;
use App\Auth\Domain\UUIDv4;
use App\Core\Infrastructure\Interface\IRepository;
use App\Core\Infrastructure\Interface\IUseCase;

class StoreUserAvatarUseCase implements IUseCase {
    public static function storeAvatarImage(string $src, $dst): void {
        try {
            move_uploaded_file($src, $dst);
        } 
        catch (Exception $e) {
            throw $e;
        }
    }
}