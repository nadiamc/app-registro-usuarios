<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Jobs\SendWelcomeEmailJob;

class RegisterController extends Controller
{
    public function create() //muestra el formulario
    {
        return view('auth.register');
    }

    public function store(Request $request) //hace toda la logic, lo que mando el formulario
    {
        // 1. Validaciones extra completas
        $validated = $request->validate([ //las validacionescon reglas encadena
            'name'     => ['required', 'string', 'min:3', 'max:255'],
            'email'    => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.unique'       => 'Este correo electrónico ya se encuentra registrado.',
            'password.confirmed' => 'Las contraseñas ingresadas no coinciden.',
        ]);

        // 2. Guardar usuario en la Base de Datos
        $user = User::create([ //ingresa a la base de datos
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']), //incripta la contraseña(nunca se guarda en texto plano)
        ]);

        // 3. Encolar el envio del correo de bienvenida mediante un Job
        SendWelcomeEmailJob::dispatch($user);

        // 4. Retornar respuesta exitosa
        return back()->with('success', '¡Usuario registrado con éxito! Correo de bienvenida enviado.'); //vuelve al formulario con el mensaje verde de exito
    }
}