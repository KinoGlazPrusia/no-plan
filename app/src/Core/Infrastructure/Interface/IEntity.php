<?php 
namespace App\Core\Infrastructure\Interface;

interface IEntity {
    public function serialize(bool $includeNulls = true): array;
}