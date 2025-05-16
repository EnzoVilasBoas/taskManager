@extends('layouts.admin')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tarefas</li>
            <li class="breadcrumb-item active" aria-current="page">Listar</li>
        </ol>
    </nav>

    <div class="card mt-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <p>Tarefas Cadastradas</p>
            <div id="pagination"></div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="task-list">
                    <!-- Usuários serão carregados aqui -->
                </tbody>
            </table>
        </div>
    </div>
@endsection