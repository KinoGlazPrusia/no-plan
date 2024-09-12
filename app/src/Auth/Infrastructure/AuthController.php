<?php
namespace App\Auth\Infrastructure;

use App\Core\Infrastructure\Interface\IUseCase;
use App\Core\Infrastructure\Interface\IService;
use App\Core\Infrastructure\Service\Request;
use App\Core\Infrastructure\Service\Response;
use App\Core\Infrastructure\Service\Sanitizer;
use App\Core\Infrastructure\Service\Validator;

use App\Auth\Domain\JWToken;

/**
 * Controlador para manejar las operaciones de autenticación.
 */
class AuthController {
    
    /**
     * Maneja el inicio de sesión de un usuario.
     *
     * @param Request $request Objeto de solicitud que contiene los datos de entrada.
     * @param IUseCase|IService $login Interfaz para el caso de uso o servicio de inicio de sesión.
     * @return void
     */
    public static function login(Request $request, IUseCase | IService $login): void {
        // Chequeamos si el usuario ya está logueado
        if (isset($_COOKIE['session_token'])) {
            // Esto solo está con fines de DEBUG (eliminar en producción)
            $decodedToken = JWToken::decodeToken($_COOKIE['session_token']);
            Response::json('error', 200, 'User already logged in', ['token' => $decodedToken]);
        }

        // Validamos la request
        if (!$request->validateQuery(['email', 'password'])) {
            Response::jsonError(400, 'Expected parameters [email, password]');
        }

        // Obtenemos los datos de la request
        $email = $request->query['email'];
        $password = $request->query['password'];

        // Sanitizamos los datos
        $email = Sanitizer::sanitizeEmail($email);

        // Validamos los datos
        $validityMessage = Validator::validateEmail($email);

        if (count($validityMessage) > 0) {
            Response::jsonError(400, implode(', ', $validityMessage));
        }

        try {
            $loggedUser = $login($email, $password);

            // Respuesta provisional (devolvemos los datos del usuario ¡sin el password!)
            $filteredUserData = $loggedUser->serialize();
            unset($filteredUserData['password']);
            Response::json('success', 200, 'Logged in', [$filteredUserData]);
        } 
        catch (\Exception $e) {
            Response::jsonError(403, $e->getMessage());
        }
    }

    /**
     * Verifica si el correo electrónico ya existe.
     *
     * @param Request $request Objeto de solicitud que contiene el correo electrónico a verificar.
     * @param IUseCase|IService $emailExists Interfaz para el caso de uso o servicio que verifica la existencia del correo.
     * @return void
     */
    public static function emailExists(Request $request, IUseCase | IService $emailExists): void {
        // Validamos la request
        if (!$request->validateQuery(['email'])) {
            Response::jsonError(400, 'Expected parameters [email]');
        }

        // Obtenemos los datos de la request
        $email = $request->query['email'];

        // Validamos los datos
        $validityMessage = Validator::validateEmail($email);

        if (count($validityMessage) > 0) {
            Response::jsonError(400, implode(', ', $validityMessage));
        }

        try {
            $exists = $emailExists($email);

            $exists ? 
                Response::json('error', 200, 'Email exists', [$exists])
                :
                Response::json('success', 200, 'Email does not exist', [$exists]);
        } 
        catch (\Exception $e) {
            Response::jsonError(403, $e->getMessage());
        }
    }

    /**
     * Verifica si el usuario está autenticado.
     *
     * @param Request $request Objeto de solicitud (no utilizado en esta función).
     * @param IUseCase|IService $isAuthenticated Interfaz para el caso de uso o servicio que verifica la autenticación del usuario.
     * @return void
     */
    public static function isAuthenticated(Request $request, IUseCase | IService $isAuthenticated): void {
        try {
            $sessionToken = $isAuthenticated();
            Response::json('success', 200, 'User authentication', [$isAuthenticated, $sessionToken]);
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    /**
     * Maneja el cierre de sesión del usuario.
     *
     * @param Request $request Objeto de solicitud (no utilizado en esta función).
     * @param IUseCase|IService $logout Interfaz para el caso de uso o servicio de cierre de sesión.
     * @return void
     */
    public static function logout(Request $request, IUseCase | IService $logout): void {
        try {
            $logout();
            Response::json('success', 200, 'User logged out');
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }

    /**
     * Recupera los datos del usuario.
     *
     * @param Request $request Objeto de solicitud (no utilizado en esta función).
     * @param IUseCase|IService $fetchUserData Interfaz para el caso de uso o servicio que obtiene los datos del usuario.
     * @return void
     */
    public static function fetchUserData(Request $request, IUseCase | IService $fetchUserData): void {
        // Validamos la request
        if (!$request->validateQuery([])) {
            Response::jsonError(400, 'Expected parameters doesn\'t match');
        }

        if (!isset($_SESSION['uid'])) {
            Response::jsonError(403, 'You are not logged in');
        }

        try {
            $user = $fetchUserData();
            Response::json('success', 200, 'User data fetched', $user->serialize(false));
        } 
        catch (\Exception $e) {
            Response::jsonError(500, $e->getMessage());
        }
    }
}
