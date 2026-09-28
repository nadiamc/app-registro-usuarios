# RESUMEN DEL TP — Registro de Usuarios + Brevo SMTP + Colas

**Proyecto:** `app-registro-usuarios`
**Tecnologías:** Laravel 13 · SQLite · Brevo SMTP · Colas (Queues) · Git/GitHub

---

## 1) Levantar el proyecto (TODO, en orden)

Abrí **dos terminales** dentro de `C:\xampp\htdocs\app-registro-usuarios`:

**Terminal 1 — el servidor web:**
```bash
php artisan serve
```
> URL: http://127.0.0.1:8000  → portada
>        http://127.0.0.1:8000/register → formulario

**Terminal 2 — el worker de colas** (el que envía los correos):
```bash
php artisan queue:work
```
> ⚠️ Si no corre, los correos se quedan guardados en la tabla `jobs` sin enviarse.

> 💡 Al tocar el `.env` conviene: `php artisan config:clear`

---

## 2) Qué es cada cosa

| Elemento | Papel |
|---|---|
| `routes/web.php` | Las URL del proyecto: portada, `/register` (GET) y envío (POST) |
| `RegisterController` | Valida el formulario, guarda al usuario y despacha el Job |
| `WelcomeUserMail` | "Sobre" del correo: asunto + vista `emails.welcome` |
| `SendWelcomeEmailJob` | Tarea de segundo plano: envía el correo (con `$tries = 3`) |
| Vistas | `home` (portada) · `auth/register` (formulario) · `emails/welcome` (correo) |
| `.env` | Config: SQLite + credenciales de Brevo SMTP (NO se sube a GitHub) |

---

## 3) Cómo funciona el flujo (así se lo explico al profe)

1. El usuario llena el formulario y lo manda.
2. El controlador **valida** los datos y guarda al usuario (contraseña con `Hash::make`).
3. Con `SendWelcomeEmailJob::dispatch($user)` se **encola** el envío del correo
   (el navegador responde rápido, no espera a que salga el mail).
4. El **worker** (`queue:work`) lee la tabla `jobs`, ejecuta el Job y envía el
   correo por **Brevo SMTP**.
5. Si falla, reintenta hasta 3 veces; si agota, pasa a `failed_jobs`.

---

## 4) Comandos de colas (Nivel 4 y 5)

```bash
php artisan queue:work      # procesa los jobs (el worker)
php artisan queue:failed    # lista los jobs que fallaron definitivamente
php artisan queue:retry all # devuelve los fallados a la cola para reintentar
```

---

## 5) Datos clave de seguridad

- El `.env` (SMTP Key de Brevo) está excluido por `.gitignore` → **no se sube a GitHub**.
- Sobre el repo: https://github.com/nadiamc/app-registro-usuarios

## 6) Pendiente / ideas para mejorar
- Nada obligatorio. Ideal: probar la demo completa enfrente del profe
  (portada → formulario → error de validación → registro exitoso → llega el mail).