<?php
namespace App\User\Infrastructure;

use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Sanitizer;
use App\Core\Infrastructure\Service\Validator;
use App\User\Infrastructure\UserRepository;
use App\Core\Infrastructure\Database\MySqlDatabase;

class UserController {
    public static function register(Request $request, IUseCase | IService $businessLogic): void {
        // Validamos la request
       /*  if (!$request->validateQuery([
            'name',
            'lastname',
            'email',
            'password',
            'birth_date',
            'genre',
            'profile_img_url'
        ])) {
            Response::jsonError(400, 'Expected parameters [name, lastname, email, password, birth_date, genre, profile_img_url]');
        }

        // Obtenemos los datos de la request
        $name = $request->query['name'];
        $lastname = $request->query['lastname'];
        $email = $request->query['email'];
        $password = $request->query['password'];
        $birth_date = $request->query['birth_date'];
        $genre = $request->query['genre'];
        $profile_img_url = $request->query['profile_img_url'];

        // Sanitizamos los datos
        $name = Sanitizer::sanitizeName($name);
        $lastname = Sanitizer::sanitizeLastname($lastname);
        $email = Sanitizer::sanitizeEmail($email);
        $password = Sanitizer::sanitizePassword($password);
        $birth_date = Sanitizer::sanitizeBirthDate($birth_date);
        $genre = Sanitizer::sanitizeGenre($genre);
        $profile_img_url = Sanitizer::sanitizeProfileImgUrl($profile_img_url);

        // Validamos los datos
        if (!Validator::validateName($name)) {
            Response::jsonError(400, 'Invalid name');
        }

        if (!Validator::validateLastname($lastname)) {
            Response::jsonError(400, 'Invalid lastname');
        }

        if (!Validator::validateEmail($email)) {
            Response::jsonError(400, 'Invalid email');
        }

        if (!Validator::validatePassword($password)) {
            Response::jsonError(400, 'Invalid password');
        }

        if (!Validator::validateBirthDate($birth_date)) {
            Response::jsonError(400, 'Invalid birth_date');
        }

        if (!Validator::validateGenre($genre)) {
            Response::jsonError(400, 'Invalid genre');
        }

        if (!Validator::validateProfileImgUrl($profile_img_url)) {
            Response::jsonError(400, 'Invalid profile_img_url');
        } */

        $registeredUser = $businessLogic(
            new UserRepository(new MySqlDatabase()),
            'name',
            'lastname',
            'email',
            'password',
            '2000-01-01',
            'genre',
            'profile_img_url'
        );

        $registeredUser ? 
            Response::json('success', 200, 'Registered user') 
            :
            Response::jsonError(400, 'Invalid data');
    }
}