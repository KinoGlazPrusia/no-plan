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

    public static function validatePlanTitle(string $title): array {
        $validityMessage = array();

        if (strlen($title) < 3) {
            $validityMessage[] = 'Invalid title: The title must be at least 3 characters long.';
        }

        return $validityMessage;
    }

    public static function validatePlanDescription(string $description): array {
        $validityMessage = array();

        if (strlen($description) < 10) {
            $validityMessage[] = 'Invalid description: The description must be at least 10 characters long.';
        }

        return $validityMessage;
    }

    public static function validatePlanDate(string $date): array {
        $validityMessage = array();

        $year = explode('-', $date)[0];
        $month = explode('-', $date)[1];
        $day = explode('-', $date)[2];

        if (!checkdate($month, $day, $year)) {
            $validityMessage[] = 'Invalid date';
        }

        if (strtotime($date) < strtotime('now')) {
            $validityMessage[] = 'Invalid date: The date must be in the future.';
        }

        return $validityMessage;
    }

    public static function validatePlanParticipation(int $participation): array {
        $validityMessage = array();

        if ($participation <= 0) {
            $validityMessage[] = 'Invalid participation: The participation must be greater than 0.';
        }

        if ($participation >= 10) {
            $validityMessage[] = 'Invalid participation: The participation must be equal orless than 10.';
        }

        return $validityMessage;
    }

    public static function validatePlanTimeline(array $timeline): array {
        $validityMessage = array();

        if (count($timeline) < 1) {
            $validityMessage[] = 'Invalid timeline: The timeline must contain at least 1 step.';
        }

        foreach ($timeline as $step) {
            $validityMessage = array_merge($validityMessage, Validator::validatePlanStep($step));
        }

        return $validityMessage;
    }

    public static function validatePlanStep(array $step): array {
        $validityMessage = array();

        if (!isset($step['title'])) {
            $validityMessage[] = 'Invalid step: The step must contain a title.';
        }

        if (!isset($step['description'])) {
            $validityMessage[] = 'Invalid step: The step must contain a description.';
        }

        if (!isset($step['time'])) {
            $validityMessage[] = 'Invalid step: The step must contain a time.';
        }

        return $validityMessage;
    }
}