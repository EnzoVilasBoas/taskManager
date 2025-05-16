@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Dashboard</h2>
    <p>Bem-vindo ao painel administrativo.</p>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Minhas tarefas</h5>
        </div>
        <div class="card-body p-0">
            @if($tarefas->isEmpty())
            <div class="p-4">
                <p class="text-muted">Nenhuma tarefa vinculada a este usuário.</p>
            </div>
            @else
            <div class="table">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Status</th>
                            <th>Criada em</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tarefas as $tarefa)
                        <tr>
                            <td>{{ $tarefa->id }}</td>
                            <td>{{ $tarefa->title }}</td>
                            <td>
                                @switch ($tarefa->status)
                                @case(1)
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Em andamento
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $tarefa->id }}" data-status="2">Concluído</a></li>
                                        <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $tarefa->id }}" data-status="3">Cancelado</a></li>
                                    </ul>
                                </div>
                                @break
                                @case(2)
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Concluído
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $tarefa->id }}" data-status="1">Em andamento</a></li>
                                        <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $tarefa->id }}" data-status="3">Cancelado</a></li>
                                    </ul>
                                </div>'
                                @break
                                @case(3)
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Cancelado
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $tarefa->id }}" data-status="1">Em andamento</a></li>
                                        <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $tarefa->id }}" data-status="2">Concluído</a></li>
                                    </ul>
                                </div>
                                @break
                                @default
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Desconhecido
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $tarefa->id }}" data-status="1">Em andamento</a></li>
                                        <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $tarefa->id }}" data-status="2">Concluído</a></li>
                                        <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $tarefa->id }}" data-status="3">Cancelado</a></li>
                                    </ul>
                                </div>
                                @endswitch
                            </td>
                            <td>{{ $tarefa->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a class="btn btn-sm btn-primary me-1 edit-user" href="/dash/tarefas/{{ $tarefa->id }}/visualizar">Visualizar</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection