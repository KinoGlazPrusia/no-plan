<?php
namespace App\Core\Infrastructure\Service;

use App\User\Domain\User;
use App\Auth\Domain\UUIDv4;

class Mock {
    public static function mockUploadedImage(): array {
        // Pendiente de implementar (quizás se puede usar vfsStream). Hacer research.
    }

    public static function newUserPostData(): User {
        $uuid = UUIDv4::_invoke();
        $hash = password_hash('1234', PASSWORD_DEFAULT);

        return new User((object)[
            'id' => $uuid,
            'name' => 'test',
            'lastname' => 'lastname',
            'email' => rand(0,1262055681) . '@gmail.com',
            'password' => $hash,
            'birth_date' => date("Y-m-d H:i:s", mt_rand(0,1262055681)),
            'genre' => array_rand(['M', 'F', 'NB', 'O', 'NS']),
            'profile_img_url' => ''
        ]);
    }
}
