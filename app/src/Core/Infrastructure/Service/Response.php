<?php
namespace App\Core\Infrastructure\Service;

/**
 * Clase para manejar y crear respuestas HTTP en formato JSON.
 */
class Response
{

    /**
     * Envía una respuesta JSON al cliente.
     *
     * @param string $status El estado de la respuesta (por ejemplo, 'success', 'error').
     * @param int $code Código de estado HTTP.
     * @param string $message Mensaje asociado con la respuesta.
     * @param array $data Datos adicionales para incluir en la respuesta (por defecto es un array vacío).
     * @return void
     */
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

    /**
     * Envía una respuesta JSON de error al cliente.
     *
     * @param int $code Código de estado HTTP.
     * @param string|null $details Detalles adicionales sobre el error (opcional).
     * @return void
     */
    public static function jsonError(int $code, string $details = null) {
        header('Content-Type: application/json');
        // http_response_code($code);
        echo json_encode([
            'status' => 'error',
            'message' => self::getErrorMessage($code),
            'error' => [
                'code' => $code,
                'message' => self::getErrorMessage($code),
                'details' => $details
            ]
        ]);
        exit;
    }

    /**
     * Obtiene el mensaje de error correspondiente a un código de estado HTTP.
     *
     * @param int $code Código de estado HTTP.
     * @return string El mensaje de error correspondiente.
     */
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