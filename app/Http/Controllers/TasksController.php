<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;

class TasksController extends Controller
{
    /**
     * Funcao responsavel pela visualizacao do cadastro de tarefas
     */
    public function showTasks()
    {
        return view('tasks');
    }

    /**
     * Funcao responsavel pelo cadastro da tarefa
     */
    public function createTask(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|max:500',
        ], [
            'title.max' => 'O titulo deve possuir no maximo 255 caracteres.',
            'description.max' => 'A descricao deve possuir no maximo 500 caracteres..',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 1,
        ]);
        
        $task->users()->attach(auth()->id());

        return redirect()->route('tarefas.list')->with('success', 'Tarefa cadastrada com sucesso.');
    }

    /**
     * Funcao responsavel pela visualizacao do cadastro de tarefas
     */
    public function showListTasks()
    {
        return view('tasksList');
    }


    public function listTasks($page = 1)
    {
        $perPage = 5;

        $offset = ($page - 1) * $perPage;

        $query = Task::select('id', 'title', 'status');
        $total = $query->count();

        $tasks = $query->skip($offset)->take($perPage)->get();

        return response()->json([
            'tasks' => $tasks,
            'current_page' => (int) $page,
            'last_page' => ceil($total / $perPage),
        ]);
    }

     public function statusUpdate($id, $status)
    {
        $task = Task::findOrFail($id);
        $task->update(['status' => $status]);

        return response()->json(['success' => true, 'message' => 'Task atualizada com sucesso.']);
    }

    public function showEdit($id) 
    {
        $task = Task::findOrFail($id);
        return view('taskEdit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|max:500',
        ], [
            'title.max' => 'O titulo deve possuir no maximo 255 caracteres.',
            'description.max' => 'A descricao deve possuir no maximo 500 caracteres..',
        ]);

        $task->title = $request->title;
        $task->description = $request->description;

        $task->save();

        return redirect()->route('task.edit', $task->id)->with('success', 'Tarefa atualizada com sucesso.');
    }

    public function returnTask($id) 
    {
        $task = Task::with('users')->findOrFail($id);

        return view('taskData', compact('task'));
    }

    public function addParticipante(Request $request, $taskId)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email' => 'O email informado nao foi localizado.',
        ]);

        $user = User::where('email', $request->email)->first();
        $task = Task::findOrFail($taskId);

        if ($task->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'O usuário já está vinculado a esta tarefa.']);
        }

        $task->users()->attach($user->id);

        return response()->json(['message' => 'Usuário vinculado com sucesso.']);
    }

    public function removeParticipante($taskId, $userId)
    {
        $task = Task::findOrFail($taskId);
        $user = User::findOrFail($userId);

        if (!$task->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'O usuário não está vinculado a esta tarefa.'], 404);
        }

        $task->users()->detach($user->id);

        return response()->json(['message' => 'Usuário removido da tarefa com sucesso.']);
    }
    
    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);

        $task->users()->detach();

        $task->delete();

        return response()->json(['message' => 'Tarefa excluída com sucesso.']);
    }
}
