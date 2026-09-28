<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP: Registro de Usuarios</title>
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
            max-width: 640px;
            width: 100%;
            text-align: center;
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

        h1 {
            font-size: 2rem;
            color: #6d28d9;
            margin-bottom: 35px;
        }

        .btn {
            display: inline-block;
            background: #a78bfa;
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            padding: 14px 34px;
            border-radius: 10px;
            transition: transform 0.2s, background 0.2s;
        }

        .btn:hover { background: #c4b5fd; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="card">
        <span class="badge">Trabajo Práctico de Programación IV</span>
        <h1>Mail desde formulario de registro</h1>

        <a class="btn" href="{{ route('register.create') }}">Ir al formulario →</a>
    </div>
</body>
</html>