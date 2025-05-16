<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TasksController;
use App\Http\Middleware\CheckPermission;

Route::get('/', function () {
    return redirect()->route('login');
});

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Painel
Route::middleware(['auth'])->group(function () {
    // Homee
    Route::get('/dash', [DashController::class, 'tarefasPorUsuario'])->name('home');
    Route::post('/dash', [DashController::class, 'login']);

    // Usuarios
    Route::middleware([\App\Http\Middleware\CheckPermission::class])->group(function () {
        Route::get('/dash/usuarios', [UserController::class, 'showUsers'])->name('usuarios'); // Retorna pagina usuarios
        Route::post('/dash/usuarios', [UserController::class, 'createUser']); // Realiza o cadastro do usuario
        Route::get('/dash/usuarios/list/{page}', [UserController::class, 'listUsers']); // Retorna a lista de usuarios via Ajax
        Route::post('/dash/usuarios/stats/{id}/{stats}', [UserController::class, 'statsUpdate']); // Atualiza o status do usuario
        Route::delete('/dash/usuarios/delete/{id} ', [UserController::class, 'delete']); // Exclui o usuario
        Route::get('/dash/usuarios/{id}/editar', [UserController::class, 'showEdit'])->name('users.edit');
        Route::put('/dash/usuarios/{id}/update', [UserController::class, 'update'])->name('users.update');
    });

    // Tarefas
    Route::get('/dash/tarefas', [TasksController::class, 'showTasks'])->name('tarefas');
    Route::post('/dash/tarefas', [TasksController::class, 'createTask']);
    Route::get('/dash/tarefas/lista', [TasksController::class, 'showListTasks'])->name('tarefas.list');
    Route::get('/dash/tarefas/list/{page}', [TasksController::class, 'listTasks']);
    Route::post('/dash/tarefas/status/{id}/{stats}', [TasksController::class, 'statusUpdate']);
    Route::get('/dash/tarefas/{id}/editar', [TasksController::class, 'showEdit'])->name('task.edit');
    Route::put('/dash/tarefas/{id}/update', [TasksController::class, 'update'])->name('task.update');
    Route::get('/dash/tarefas/{id}/visualizar', [TasksController::class, 'returnTask'])->name('tarefas.return');
    Route::post('/dash/tarefas/{id}/participante', [TasksController::class, 'addParticipante']);
    Route::delete('/dash/tarefas/remove/{id}/{user}', [TasksController::class, 'removeParticipante']);
    Route::delete('/dash/tarefas/delete/{id}', [TasksController::class, 'deleteTask']);

});