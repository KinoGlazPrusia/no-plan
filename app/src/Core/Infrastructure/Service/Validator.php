<?php
namespace App\Core\Infrastructure\Service;

use App\User\Domain\UserGenre;

class Validator
{
    public static function validateEmail(string $email): array {
        $validityMessage = array();

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validityMessage[] = 'Invalid email';
        }

        return $validityMessage;
    }

    public static function validateName(string $name): array {
        // [ ] Revisar la validación del nombre en frontend ya que al insertar números esta regex falla
        $validityMessage = array();
    
        // Check if the name only contains letters and spaces, including UTF-8 characters
        if (!preg_match('/^[\p{L}\s]+$/u', $name)) {
            $validityMessage[] = 'Invalid name: The name must contain only letters and spaces.';
        }
    
        return $validityMessage;
    }

    public static function validateGenre(string $genre): array {
        $validityMessage = array();

        if (!in_array($genre, UserGenre::getAll())) {
            $validityMessage[] = 'Invalid genre';
        }

        return $validityMessage;
    }

    public static function validateDate(string $date): array {
        $validityMessage = array();

        $year = explode('-', $date)[0];
        $month = explode('-', $date)[1];
        $day = explode('-', $date)[2];

        if (!checkdate($month, $day, $year)) {
            $validityMessage[] = 'Invalid date';
        }

        return $validityMessage;
    }

    public static function validateUploadedImage(array $file): array {
        $validityMessage = array();

        if (!isset($file['tmp_name'])) {
            $validityMessage[] = 'Invalid file';
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            $validityMessage[] = 'File not uploaded';
        }

        if (!file_exists($file['tmp_name'])) {
            $validityMessage[] = 'File not found';
        }

        if (!in_array($file['type'], [
            'image/png',
            'image/jpg',
            'image/jpeg'
        ])) {
            $validityMessage[] = 'Invalid image type';
        }

        if ($file['size'] > 10000 * 1000) {
            $validityMessage[] = 'Image is too big';
        }

        return $validityMessage;
    }
}