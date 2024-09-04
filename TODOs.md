# TODOs

## WORKING ON ...
- [x] Crear el formulario de registro de planes + Página de registro funcional
- [x] Crear la página de visualización de planes (con acción de suscripción y cancelación)
- [ ] Terminar de implementar la función de aceptar o rechazar un participante
- [ ] Implementar la llamada al endpoint para suscribirse a un plan (componente de PlanCard)
--------
- [ ] Crear la página de usuario con visualización de notificaciones
- [ ] Crear la acción de aceptar o rechazar solicitudes dentro de la página de notificaciones.


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

## DATABASE
- [x] Revisar el manejo de excepciones en MySqlDatabase.php
- [x] Añadir un campo rol para la tabla user.
- [ ] Añadir el campo phone a la tabla users e implementarlo en el servidor.
- [ ] Revisar el modelo. Creo que debería añadirse un campo en la tabla de rating_criteria para definir si es criterio de usuario o criterio de plan ya que no todos podrán compartirse.
- [ ] Incluir campo teléfono en la tabla 'user' (añadirlo la gestión en servidor al registrar usuario).

## OTROS
- [x] Los planes podrían tener un timeline.
- [ ] La iluminación/color-tinte del mapa cambia según la hora del día.



