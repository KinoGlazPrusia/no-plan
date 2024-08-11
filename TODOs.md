# TODOs

## WORKING ON ...
- [ ] Crear endpoint para hacer un fetch de todos los planes.
- [ ] Crear endpoint para hacer un fetch de todos los planes de un usuario.

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



