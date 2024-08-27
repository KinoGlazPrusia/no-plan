<?php
namespace App;

/* CORE */
use App\Core\Infrastructure\Database\MySqlDatabase;

/* AUTH */
use App\Auth\Infrastructure\AuthController;
use App\Auth\Infrastructure\AuthRepository;
use App\Auth\Application\LoginUseCase;
use App\Auth\Application\LogoutUseCase;
use App\Auth\Application\EmailExistsUseCase;
use App\Auth\Application\CheckAuthenticationUseCase;

/* USER */
use App\User\Infrastructure\UserController;
use App\User\Infrastructure\UserRepository;
use App\User\Application\RegisterUserService;

/* PLAN */
use App\Plan\Infrastructure\PlanController;
use App\Plan\Infrastructure\PlanRepository;
use App\Plan\Application\GetAllPlanCategoriesUseCase;
use App\Plan\Application\CreatePlanService;
use App\Plan\Application\GetAllPlansService;
use App\Plan\Application\UpdatePlanService;

/* PARTICIPACION */
use App\Participation\Infrastructure\ParticipationController;
use App\Participation\Infrastructure\ParticipationRepository;
use App\Participation\Application\SuscribeToPlanService;
use App\Participation\Application\AcceptParticipationService;
use App\Participation\Application\RejectParticipationService;
use App\Participation\Application\CancelSubscriptionToPlanService;
use App\Participation\Application\GetAllAcceptedParticipationsByPlanUseCase;

/**
 * Clase Routes que gestiona las rutas definidas en la aplicación.
 */
class Routes
{
    /**
     * Verifica si una ruta existe para un método HTTP y path específicos.
     *
     * @param string $method Método HTTP (por ejemplo, GET, POST).
     * @param string $path Path de la URL.
     * @return bool Retorna true si la ruta existe, false en caso contrario.
     */
    public static function routeExists(string $method, string $path): bool {
        return isset(self::getAll()[$method][$path]) ? true : false;
    } 
    // [ ] Revisar acceso a los endpoints (privado / publico)
    /**
     * Obtiene todas las rutas definidas en la aplicación.
     *
     * @return array Arreglo de todas las rutas.
     */
    public static function getAll() {
        // LA INYECCIÓN DE DEPENDENCIAS (DI) SE MANEJA DESDE AQUÍ
        // SE INYECTA UNA NUEVA INSTANCIA DE LA DEPENDENCIA EN LAS CLASES QUE LA ESPERAN
        // LAS CLASES QUE ESPERAN UNA DI, ESPERAN COMO PARÁMETRO UNA INTERFAZ (ABSTRACCIÓN)
        return [
            'GET' => [
                'email-exists' => [
                    'controller' => [AuthController::class, 'emailExists'],
                    'logic' => new EmailExistsUseCase(new AuthRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'is-authenticated' => [
                    'controller' => [AuthController::class, 'isAuthenticated'],
                    'logic' => new CheckAuthenticationUseCase(),
                    'access' => 'public'
                ],
                'logout' => [
                    'controller' => [AuthController::class, 'logout'],
                    'logic' => new LogoutUseCase(),
                    'access' => 'private'
                ],
                'categories' => [
                    'controller' => [PlanController::class, 'fetchAllCategories'],
                    'logic' => new GetAllPlanCategoriesUseCase(new PlanRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'plans' => [
                    'controller' => [PlanController::class, 'fetchAllPlans'],
                    'logic' => new GetAllPlansService(new PlanRepository(new MySqlDatabase)),
                    'access' => 'public' // [ ] Cambiar acceso a privado
                ],
                'participate' => [
                    'controller' =>[ParticipationController::class, 'suscribeToPlan'],
                    'logic' => new SuscribeToPlanService(new ParticipationRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'accept-participation' => [
                    'controller' => [ParticipationController::class, 'acceptParticipation'],
                    'logic' => new AcceptParticipationService(new ParticipationRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'reject-participation' => [
                    'controller' => [ParticipationController::class, 'rejectParticipation'],
                    'logic' => new RejectParticipationService(new ParticipationRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'cancel-participation' => [
                    'controller' => [ParticipationController::class, 'cancelParticipation'],
                    'logic' => new CancelSubscriptionToPlanService(new ParticipationRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'accepted-participations' => [
                    'controller' => [ParticipationController::class, 'getAllAcceptedParticipations'],
                    'logic' => new GetAllAcceptedParticipationsByPlanUseCase(new ParticipationRepository(new MySqlDatabase)),
                    'access' => 'public'
                ]
            ],
            'POST' => [
                'login' => [
                    'controller' => [AuthController::class, 'login'],
                    'logic' => new LoginUseCase(new AuthRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'register' => [
                    'controller' => [UserController::class, 'register'],
                    'logic' => new RegisterUserService(new UserRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'create-plan' => [
                    'controller' => [PlanController::class, 'create'],
                    'logic' => new CreatePlanService(new PlanRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'update-plan' => [
                    'controller' => [PlanController::class, 'update'],
                    'logic' => new UpdatePlanService(new PlanRepository(new MySqlDatabase)),
                    'access' => 'public' // [ ] Cambiar acceso a 'private' cuando se implemente el caso de uso
                ]
            ]
        ];
    }
}