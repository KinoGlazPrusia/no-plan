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
use App\Auth\Application\GetLoggedUserFilteredDataUseCase;

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
use App\Plan\Application\GetAllCreatedPlansService;
use App\Plan\Application\GetAllAcceptedPlansService;
use App\Plan\Application\GetAllRejectedPlansService;
use App\Plan\Application\GetAllPendingPlansService;
use App\Plan\Application\UpdatePlanService;
use App\Plan\Application\GetPlanByIdService;
use App\Plan\Application\CountAllNotCreatedPlansUseCase;
use App\Plan\Application\CountAllCreatedPlansUseCase;
use App\Plan\Application\CountAllAcceptedPlansUseCase;
use App\Plan\Application\CountAllRejectedPlansUseCase;
use App\Plan\Application\CountAllPendingPlansUseCase;

/* PARTICIPACION */
use App\Participation\Infrastructure\ParticipationController;
use App\Participation\Infrastructure\ParticipationRepository;
use App\Participation\Application\SuscribeToPlanService;
use App\Participation\Application\AcceptParticipationService;
use App\Participation\Application\RejectParticipationService;
use App\Participation\Application\CancelSubscriptionToPlanService;
use App\Participation\Application\GetAllAcceptedParticipationsByPlanUseCase;
use App\Participation\Application\GetAllPendingParticipationsByPlanUseCase;
use App\Participation\Application\GetAllRejectedParticipationsByPlanUseCase;

/* NOTIFICATION */
use App\Notification\Infrastructure\NotificationController;
use App\Notification\Infrastructure\NotificationRepository;
use App\Notification\Application\CheckForUnreadNotificationsUseCase;
use App\Notification\Application\SetNotificationAsReadUseCase;
use App\Participation\Domain\Participation;

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
                'plans/created' => [
                    'controller' => [PlanController::class, 'fetchAllCreatedPlans'],
                    'logic' => new GetAllCreatedPlansService(new PlanRepository(new MySqlDatabase)),
                    'access' => 'public' // [ ] Cambiar acceso a privado
                ],
                'plans/accepted' => [
                    'controller' => [PlanController::class, 'fetchAllAcceptedPlans'],
                    'logic' => new GetAllAcceptedPlansService(new PlanRepository(new MySqlDatabase)),
                    'access' => 'public' // [ ] Cambiar acceso a privado
                ],
                'plans/rejected' => [
                    'controller' => [PlanController::class, 'fetchAllRejectedPlans'],
                    'logic' => new GetAllRejectedPlansService(new PlanRepository(new MySqlDatabase)),
                    'access' => 'public' // [ ] Cambiar acceso a privado
                ],
                'plans/pending' => [
                    'controller' => [PlanController::class, 'fetchAllPendingPlans'],
                    'logic' => new GetAllPendingPlansService(new PlanRepository(new MySqlDatabase)),
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
                ],
                'pending-participations' => [
                    'controller' => [ParticipationController::class, 'getAllPendingParticipations'],
                    'logic' => new GetAllPendingParticipationsByPlanUseCase(new ParticipationRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'rejected-participations' => [
                    'controller' => [ParticipationController::class, 'getAllRejectedParticipations'],
                    'logic' => new GetAllRejectedParticipationsByPlanUseCase(new ParticipationRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'notifications/unread' => [
                    'controller' => [NotificationController::class, 'getUnreadNotifications'],
                    'logic' => new CheckForUnreadNotificationsUseCase(new NotificationRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'notifications/set-read' => [
                    'controller' => [NotificationController::class, 'setNotificationAsRead'],
                    'logic' => new SetNotificationAsReadUseCase(new NotificationRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'plan' => [
                    'controller' => [PlanController::class, 'fetchPlanData'],
                    'logic' => new GetPlanByIdService(new PlanRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'user-data' => [
                    'controller' => [AuthController::class, 'fetchUserData'],
                    'logic' => new GetLoggedUserFilteredDataUseCase(new UserRepository(new MySqlDatabase)),
                    'access' => 'public'
                ],
                'plans-count' => [
                    'controller' => [PlanController::class, 'countAllNotCreatedPlans'],
                    'logic' => new CountAllNotCreatedPlansUseCase(new PlanRepository(new MySqlDatabase)),
                    'access' => 'private'
                ],
                'plans-count/created' => [
                    'controller' => [PlanController::class, 'countAllCreatedPlans'],
                    'logic' => new CountAllCreatedPlansUseCase(new PlanRepository(new MySqlDatabase)),
                    'access' => 'private'
                ],
                'plans-count/accepted' => [
                    'controller' => [PlanController::class, 'countAllAcceptedPlans'],
                    'logic' => new CountAllAcceptedPlansUseCase(new PlanRepository(new MySqlDatabase)),
                    'access' => 'private'
                ],
                'plans-count/rejected' => [
                    'controller' => [PlanController::class, 'countAllRejectedPlans'],
                    'logic' => new CountAllRejectedPlansUseCase(new PlanRepository(new MySqlDatabase)),
                    'access' => 'private'
                ],
                'plans-count/pending' => [
                    'controller' => [PlanController::class, 'countAllPendingPlans'],
                    'logic' => new CountAllPendingPlansUseCase(new PlanRepository(new MySqlDatabase)),
                    'access' => 'private'
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