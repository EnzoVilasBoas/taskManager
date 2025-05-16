<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Funcao responsavel por retornar a view
     */
    public function showUsers()
    {
        return view('users');
    }

    /**
     * Funcao responsavel por cadastrar os usuarios
     */
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email|unique:users,email|max:200',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.max' => 'O nome deve possuir no maximo 200 caracteres.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'email.max' => 'O email deve possuir no maximo 200 caracteres..',
            'password.min' => 'A senha deve possuir pelo menos 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'stats' => 1,
            'permission' => 0,
        ]);

        return redirect()->back()->with('success', 'Usuário cadastrado com sucesso!');
    }

    /**
     * Funcao responsavel pela listagem dos usuarios
     */
    public function listUsers($page = 1)
    {
        $perPage = 5;

        $offset = ($page - 1) * $perPage;

        $query = User::select('id', 'name', 'email', 'stats');
        $total = $query->count();

        $users = $query->skip($offset)->take($perPage)->get();

        return response()->json([
            'users' => $users,
            'current_page' => (int) $page,
            'last_page' => ceil($total / $perPage),
        ]);
    }

    /**
     * Funcao responsavel por atualizar o status
     */
    public function statsUpdate($id, $stats)
    {
        $user = User::findOrFail($id);
        if ($stats == "off") {
            $user->update(['stats' => 1]);
        } elseif ($stats == "on") {
            $user->update(['stats' => 0]);
        }

        return response()->json(['success' => true, 'message' => 'Usuário desativado com sucesso.']);
    }

    /**
     * Funcao responsavel por excluir o usuario
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Funcao responsavel por retornar a view para edicao
     */
    public function showEdit($id)
    {
        $user = User::findOrFail($id);
        return view('userEdit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:200',
            'email' => 'required|email|unique:users,email,'.$id.'|max:200',
        ];

        // Se a senha foi preenchida, adiciona validação
        if ($request->filled('password')) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $request->validate($rules,[
            'name.max' => 'O nome deve possuir no maximo 200 caracteres.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'email.max' => 'O email deve possuir no maximo 200 caracteres..',
            'password.min' => 'A senha deve possuir pelo menos 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.edit', $user->id)->with('success', 'Usuário atualizado com sucesso.');
    }
}
