<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class DashController extends Controller
{
    public function showDash()
    {
        return view('dashboard');
    }

    public function tarefasPorUsuario()
    {
        $usuario = User::with('tasks')->findOrFail(auth()->id());

        $tarefas = $usuario->tasks;

        return view('dashboard', compact('usuario', 'tarefas'));
    }
}
