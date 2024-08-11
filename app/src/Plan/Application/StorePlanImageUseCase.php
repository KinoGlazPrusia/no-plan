<?php
namespace App\Plan\Application;

use App\Core\Infrastructure\Interface\IUseCase;

class StorePlanImageUseCase implements IUseCase {
    public static function store(string $src, $dst): void {
        try {
            move_uploaded_file($src, $dst);
        } 
        catch (\Exception $e) {
            throw $e;
        }
    }
}