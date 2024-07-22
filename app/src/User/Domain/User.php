<?php
namespace App\User\Domain;

use DateTime;
use App\Core\Domain\CoreEntity;

class User extends CoreEntity {
    public readonly string | null $id;
    public readonly string | null $name;
    public readonly string | null $lastname;
    public readonly string | null $email;
    public readonly string | null $password;
    public readonly string |null $birth_date;
    public readonly string | null $genre;
    public readonly string | null $profile_img_url;
    public readonly string |null $last_connection;

    public function __construct(Object | null $data = null) {
        parent::__construct(
            'user',
            [
                'id',
                'email',
                'name',
                'lastname',
                'password',
                'birth_date',
                'genre',
                'profile_img_url',
                'last_connection'
            ]
        );

        $this->id = isset($data->id) ? $data->id : null;
        $this->name = isset($data->name) ? $data->name : null;
        $this->lastname = isset($data->lastname) ? $data->lastname : null;
        $this->email = isset($data->email) ? $data->email : null;
        $this->password = isset($data->password) ? $data->password : null;
        $this->birth_date = isset($data->birth_date) ? $data->birth_date : null;
        $this->genre = isset($data->genre) ? $data->genre : null;
        $this->profile_img_url = isset($data->profile_img_url) ? $data->profile_img_url : null;
        $this->last_connection = isset($data->last_connection) ? $data->last_connection : null;
    }

    /* SETTERS */
    public function setId(string $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setLastname(string $lastname): void {
        $this->lastname = $lastname;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function setBirthDate(string $timestamp): void {
        $this->birth_date = $timestamp;
    }

    public function setGenre(string $genre): void {
        $this->genre = $genre;
    }

    public function setProfileImgUrl(string $profile_img_url): void {
        $this->profile_img_url = $profile_img_url;
    }
}
