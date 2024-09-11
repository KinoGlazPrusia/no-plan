# TODOs

## WORKING ON ...
- [x] Crear la página de calendario, en el que salgan chips de notificación con el número
de planes para el día (en vista de calendario), y al apretar sobre la chip, se despliegue un carousel en el que se puedan visualizar todas las cards del plan e interactuar con ellas.
- [ ] Revisar bug en el cálculo de la edad del user avatar
- [ ] Implementar validaciones pendientes en los formularios de:
        - Creación de plan
        - Edición de plan
        - Plan step 
- [ ] Implementar la función de sort del plan-timeline (por hora)
- [x] Crear un logo y añadirlo a las páginas (revisar el diseño en general) (añadir también un caption en la página de login/signup, estilo 'Plan, meet, enjoy')
- [ ] Implementar los iconos de categoría en las 'plan-cards' (con un tooltip al hacer hover)
- [ ] Incluir varios temas que se activen según la hora (mañana, día, tarde, noche)
- [ ] Implementar un placeholder en la imagen del plan-card si esta no carga o no se encuentra (basado en la categoría del plan)
- [ ] Crear la página de usuario
- [ ] Solucionar el bug en el formulario de registro de usuarios (activación del botón submit)

*El sistema de notificaciones debería de hacerse a través de eventos de dominio pero no hay
tiempo para implementarlo*

## FRONTEND
- [x] Implementar el método en la api del frontend para hacer login a través de POST
- [x] Implementar método en el componente input para mantener el cursor en la última posición en la que estaba (para así poder modificar diferentes puntos del input sin que se vaya al final constantemente)
- [x] Crear componente DateInput.
- [x] Crear componente SignUpForm.
- [x] Crear componente PhoneInput.
- [x] Crear componente SelectInput.
- [x] Crear componente FileInput (recuperarlo del ejercicio de los mapas).
- [x] Implementar un TTL y si no se recibe respuesta del servidor devolver una pantalla de error.
- [x] Implementar una plantilla de error de servidor 
- [x] Implementar un spinner para cargas y un mensaje de éxito o error al registrar el usuario.
- [x] Implementar la función isAuthenticated() de api.auth.js.
- [x] Crear componente CreatePlanForm.
- [x] Incluir el manejo de mensajes de 'success' en el componente FormFeedback.
- [x] Hacer el SelectInput dinámico (que acepte un array) y con estilos personalizados.
- [x] Crear componente PlanTimeline
- [x] Crear modal para añadir 'steps' a un plan.
- [x] Crear el formulario de registro de planes + Página de registro funcional
- [x] Crear la página de visualización de planes (con acción de suscripción y cancelación)
- [x] !!! IMPORTANTE !!! Implementar un método para restaurar los datos de usuario en el contexto cuando se restaure la sesión a través del token. !!! BUG !!!
- [x] Implementar un componente 'toast' para mostrar mensajes al usuario (de momento solo los de error)
- [x] Terminar de implementar la función de aceptar a un participante
- [x] Terminar de implementar la función de rechazar a un participante
- [x] Implementar la llamada al endpoint para suscribirse a un plan (componente de PlanCard)
- [ ] Crear endpoint para hacer un fetch de todos los planes de un usuario.
- [ ] En el componente FormFeedback, añadir un modal cuando el mensaje supere las 2 líneas.
- [ ] Completar validaciones para el SignUpForm.
- [ ] Implementar validaciones en todos los componentes del frontend.
- [ ] Implementar formateo automático del PhoneInput.
- [ ] Mejorar los componentes PhoneInput y SelectInput
- [ ] En el CreatePlanForm, añadir feedback (con scrollbar o flechas animadas) para dar a entender al usuario que puede hacer scroll.

## BACKEND
- [x] Integrar login
- [x] Revisar las respuestas de error al hacer login (en servidor: jsonError)
- [x] Revisar la clase Request para ver como captura los parámetros en el atributo query para request con un método POST.
- [x] Separar la lógica de registro de usuario en un serivicio que coordina distintos casos de uso (crear usuario, guardar avatar, enviar email de activación, etc.).
- [x] Crear un UseCase CreateUserRoleUseCase (para admin)
- [x] Recuperar e insertar los roles en una variable de sesión y en el token
- [x] Crear endpoint para hacer un fetch de todos los planes.
- [x] Crear endpoint para suscribirse a un plan.
- [x] Crear sistema de notificación para el creador del plan al recibir una solicitud.
- [x] Crear endpoint para aceptar una participación.
- [x] Crear sistema de notificación al participante de un plan cuando se acepte una solicitud (notificación en la app y por email)
- [x] Crear endpoint para revocar una participación.
- [x] Crear sistema de notificación al participante de un plan cuando se revoca una solicitud (notificación en la app y por email).
- [x] Implementar el caso de uso: GetAllAcceptedParticipations
- [x] Implementar el caso de uso: GetAllPendingParticipations
- [x] Implementar el caso de uso: CheckForUnreadNotifications
- [x] Implementar el caso de uso: SetNotificationAsRead
- [x] Revisar el error con el session_token dentro del contenedor de docker
- [ ] Limpiar las respuestas Json del servidor eliminando los campos redundantes y "columns" y "table".
- [ ] Revisar todo el sistema de autenticación (parece que a veces la sesión caduca pero el token no repone los datos de sesión, revisar sobretodo el caso de uso de checkAuthentication).
- [ ] Encapsular y automatizar la sanitización y la validación de datos en funciones únicas encerradas en un try catch !!! IMPORTANTE !!!
- [ ] Implementar edición de planes.
- [ ] Crear endpoint para actualizar el status de un plan.
- [ ] Revisar que todos los datos recibidos en el controlador llegan a la capa de aplicación como objetos (no como arrays).
- [ ] Sustituir todos los atributos readonly por setters y getters de atributos protected !!! IMPORTANTE !!!
- [ ] Terminar de implementar el 'permissionGate'.
- [ ] Añadir una función en servidor para chequear si el usuario está logueado y el rol del usuario para permitir que acceda a un endpoint o no.
- [ ] Implementar un método para devolver respuesta en caso de que el servidor no responda.
- [ ] En la creación de usuario, habría que extraer el rollback al caso de uso para poder hacerlo en caso de que no se pueda guardar la imagen o enviar el email de confirmación. Buscar y revisar un vídeo de CodelyTV que hablaba de mover la lógica de bases de datos transaccionales a la capa de aplicación (creo que se llama BBDD transaccionales).
- [ ] Rehacer el test de registro de usuarios.
- [ ] Añadir el módulo de 'rating'

## DATABASE
- [x] Revisar el manejo de excepciones en MySqlDatabase.php
- [x] Añadir un campo rol para la tabla user.
- [x] Añadir el campo phone a la tabla users e implementarlo en el servidor.
- [ ] Revisar el modelo. Creo que debería añadirse un campo en la tabla de rating_criteria para definir si es criterio de usuario o criterio de plan ya que no todos podrán compartirse.
- [ ] Incluir campo teléfono en la tabla 'user' (añadirlo la gestión en servidor al registrar usuario).

## OTROS
- [x] Los planes podrían tener un timeline.
- [ ] La iluminación/color-tinte del mapa cambia según la hora del día.



