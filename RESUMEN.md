# RESUMEN DEL TP — Registro + Brevo SMTP + Colas

Proyecto: `C:\xampp\htdocs\app-registro-usuarios`
Tecnologías: Laravel 13, SQLite, Brevo SMTP, Queues (database)

---

## QUÉ SE HIZO (en orden)

1. **Crear proyecto**: `composer create-project laravel/laravel app-registro-usuarios`
2. **Activar SQLite** en `C:\xampp\php\php.ini`: quitar `;` a las líneas
   `extension=pdo_sqlite` y `extension=sqlite3`. Sin esto Laravel no habla con SQLite.
3. **Migraciones**: `php artisan migrate` (crea tablas `users`, `cache`, `jobs`).
4. **Config `.env`** (sección MAIL_*):
   - MAIL_MAILER=smtp, MAIL_HOST=smtp-relay.brevo.com, MAIL_PORT=587, MAIL_SCHEME=smtp
   - MAIL_USERNAME = login de Brevo (`...@smtp-brevo.com`)
   - MAIL_PASSWORD = SMTP Key de 64 caracteres (empieza con `xsmtpsib-…`)
   - MAIL_FROM_ADDRESS = remitente verificado en Brevo (nuestra gmail)
   - QUEUE_CONNECTION=database (colas en la BD, ya viene así en Laravel 13)
   - `php artisan config:clear` después de tocar .env
5. **`app/Mail/WelcomeUserMail.php`**: el "sobre" del correo.
   - `implements ShouldQueue` → se encola automáticamente
   - `$tries = 3` → reintenta si Brevo falla
   - `envelope()` asunto · `content()` usa la vista `emails.welcome` y pasa `$nombre`
6. **Vistas Blade**:
   - `resources/views/emails/welcome.blade.php` → plantilla HTML del correo (usa `{{ $nombre }}`)
   - `resources/views/auth/register.blade.php` → formulario con `@csrf`, `old()`, `@error`
7. **`app/Http/Controllers/RegisterController.php`**:
   - `create()` muestra el formulario · `store()` procesa el registro
   - validaciones: name (min 3), email (`email:rfc,dns` + `unique:users`), password (`min:8` + `confirmed`)
   - mensajes de error en español
   - guarda con `Hash::make`, envía con `Mail::to()->send(new WelcomeUserMail(...))`
8. **Rutas** en `routes/web.php`: GET y POST `/register` con nombres
   `register.create` y `register.store` (por eso el form dice `route('register.store')`).
9. **Prueba completa**:
   - `php artisan serve` → http://127.0.0.1:8000/register
   - enviar vacío = errores en rojo · enviar válido = mensaje verde
   - `php artisan queue:work` (en OTRA terminal) → procesa el correo
   - Brevo verificó el remitente y el correo de bienvenida llegó ✅

---

## CÓMO LEVANTARLO MAÑANA (orden)

1. Terminal 1:
   ```
   cd C:\xampp\htdocs\app-registro-usuarios
   php artisan serve
   ```
2. Terminal 2 (importante para que salgan los correos):
   ```
   cd C:\xampp\htdocs\app-registro-usuarios
   php artisan queue:work
   ```
3. Navegador → http://127.0.0.1:8000/register

---

## LO QUE QUEDA (último paso de la guía: Nivel 4)

Crear un **Job dedicado** `SendWelcomeEmailJob` (alternativa avanzada a que el Mailable
tenga `ShouldQueue`). Quedaba pendiente de hacer:

- [ ] `php artisan make:job SendWelcomeEmailJob`
- [ ] Editarlo (recibe el User y envía el mailable)
- [ ] **Sacarle** `implements ShouldQueue` al Mailable (evitar redundancia)
- [ ] En el controlador: `SendWelcomeEmailJob::dispatch($user);`

---

## CONCEPTOS CLAVE PARA EL TP (examen oral)

- **Cola (Queue)**: desacopla tareas lentas (correo) del ciclo HTTP. El navegador responde
  rápido y el worker hace el trabajo en 2º plano.
- **Worker** (`queue:work`): proceso que lee la tabla `jobs` y ejecuta cada tarea.
- **ShouldQueue**: interfaz que hace que un Mailable/Job se procese de forma asíncrona.
- **`$tries`**: cantidad de reintentos si falla; al agotarse pasa a `failed_jobs`.
- **`@csrf`**: token de seguridad obligatorio en todo formulario POST.
- **`old()`**: conserva el valor del campo cuando falla la validación.
- **Validaciones**: `unique:users,email`, `email:rfc,dns`, `confirmed`, `min`, `max`.
- **Hash::make()**: encripta la contraseña (nunca se guarda texto plano).