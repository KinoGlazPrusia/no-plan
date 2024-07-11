<?php
namespace App\Core\Service;

class Response
{
    public static function json(string $status, int $code, string $message, array $data = [])
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }

    public static function jsonError(string $status, int $code, string $message, string $details = null) {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'error' => [
                'code' => $code,
                'message' => self::getErrorMessage($code),
                'details' => $details
            ]
        ]);
        exit;
    }

    public static function getErrorMessage(int $code): string {
        switch ($code) {
            case 404:
                return 'Not Found';
            case 400:
                return 'Bad Request';
            case 403:
                return 'Forbidden';
            case 401:
                return 'Unauthorized';
            case 405:
                return 'Method Not Allowed';
            case 406:
                return 'Not Acceptable';
            case 409:
                return 'Conflict';
            case 412:
                return 'Precondition Failed';
            case 415:
                return 'Unsupported Media Type';
            case 500:
                return 'Internal Server Error';
            default:
                return 'Unknown Error';
        }
    }
}