<?php
namespace App\User\Domain;

use App\Core\Domain\CoreEntity;

/**
 * Representa una entidad de usuario en el dominio.
 */
class User extends CoreEntity {
    public readonly string | null $id;
    public readonly string | null $name;
    public readonly string | null $lastname;
    public readonly string | null $email;
    public readonly string | null $password;
    public readonly string | null $birth_date;
    public readonly string | null $genre;
    public readonly string | null $profile_img_url;
    public readonly string | null $last_connection;

    /**
     * Constructor de la clase User.
     *
     * @param object|null $data Datos iniciales del usuario. Debe ser un objeto con propiedades correspondientes a los atributos del usuario.
     */
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
    
    /**
     * Establece el ID del usuario.
     *
     * @param string $id El ID del usuario.
     * @return void
     */
    public function setId(string $id): void {
        $this->id = $id;
    }

    /**
     * Establece el nombre del usuario.
     *
     * @param string $name El nombre del usuario.
     * @return void
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * Establece el apellido del usuario.
     *
     * @param string $lastname El apellido del usuario.
     * @return void
     */
    public function setLastname(string $lastname): void {
        $this->lastname = $lastname;
    }

    /**
     * Establece el correo electrónico del usuario.
     *
     * @param string $email El correo electrónico del usuario.
     * @return void
     */
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    /**
     * Establece la contraseña del usuario.
     *
     * @param string $password La contraseña del usuario.
     * @return void
     */
    public function setPassword(string $password): void {
        $this->password = $password;
    }

    /**
     * Establece la fecha de nacimiento del usuario.
     *
     * @param string $timestamp La fecha de nacimiento del usuario.
     * @return void
     */
    public function setBirthDate(string $timestamp): void {
        $this->birth_date = $timestamp;
    }

    /**
     * Establece el género del usuario.
     *
     * @param string $genre El género del usuario.
     * @return void
     */
    public function setGenre(string $genre): void {
        $this->genre = $genre;
    }

    /**
     * Establece la URL de la imagen de perfil del usuario.
     *
     * @param string $profile_img_url La URL de la imagen de perfil del usuario.
     * @return void
     */
    public function setProfileImgUrl(string $profile_img_url): void {
        $this->profile_img_url = $profile_img_url;
    }
}
