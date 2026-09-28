<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e9ddf9 0%, #d9c7f5 100%);
            color: #3b0764;
            padding: 20px;
        }

        .card {
            background: #f3eafb;
            border: 1px solid #d8c7f5;
            border-radius: 20px;
            padding: 50px 40px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(109, 40, 217, 0.15);
        }

        .badge {
            display: inline-block;
            background: #a78bfa;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 6px 14px;
            border-radius: 50px;
            margin-bottom: 20px;
        }

        h2 { font-size: 1.6rem; color: #6d28d9; margin-bottom: 25px; }

        .success {
            background: #e9f9ec;
            border: 1px solid #a5d6a7;
            color: #2e7d32;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .field { margin-bottom: 18px; }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.9rem;
            color: #6d28d9;
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d8c7f5;
            border-radius: 10px;
            background: #faf7ff;
            color: #3b0764;
            font-size: 1rem;
            outline: none;
            transition: border 0.2s, background 0.2s;
        }

        input:focus {
            border-color: #a78bfa;
            background: #ffffff;
        }

        .error {
            display: block;
            margin-top: 6px;
            color: #d94f4f;
            font-size: 13px;
        }

        .btn {
            width: 100%;
            background: #a78bfa;
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            padding: 14px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
            margin-top: 6px;
        }

        .btn:hover { background: #c4b5fd; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="card">
        <span class="badge">Trabajo Práctico de Programación IV</span>
        <h2>Formulario de Registro</h2>

        @if(session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="field">
                <label for="name">Nombre Completo:</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}">
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="email">Correo Electrónico:</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}">
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="password">Contraseña:</label>
                <input id="password" type="password" name="password">
                @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="password_confirmation">Confirmar Contraseña:</label>
                <input id="password_confirmation" type="password" name="password_confirmation">
            </div>

            <button class="btn" type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>