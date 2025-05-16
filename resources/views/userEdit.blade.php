@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('usuarios') }}">Usuários</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar usuário</li>
        </ol>
    </nav>

<!-- Card de Cadastro de Usuário -->
<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        Editar usuário
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $erro)
                <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name">Nome</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="password">Nova senha (opcional)</label>
                <input type="password" class="form-control" name="password">
            </div>

            <div class="mb-3">
                <label for="password_confirmation">Confirmar senha</label>
                <input type="password" class="form-control" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
        </form>
    </div>
</div>
@endsection