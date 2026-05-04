<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Rules\CedulaEcuador;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'cedula' => ['required', 'string', 'unique:'.Usuario::class, new CedulaEcuador],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Usuario::class],
            'semestre' => ['required', 'integer', 'min:1', 'max:6'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'email' => $request->email,
            'semestre' => $request->semestre,
            'password' => Hash::make($request->password),
            'rol' => 'estudiante',
        ]);

        event(new Registered($usuario));

        Auth::login($usuario);

        return redirect(route('dashboard', absolute: false));
    }
}
