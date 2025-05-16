<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth'); // Crie essa view com seu formulário
    }

    public function login(Request $request)
    {
        // Validação dos dados do formulário
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentativa de login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dash'); // ou sua rota de destino
        }

        // Se falhar, volta com erro
        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->withInput();
    }
}