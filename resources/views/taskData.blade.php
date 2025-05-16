@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tarefas.list') }}">Tarefas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Visualizar tarefa</li>
    </ol>
</nav>

<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        {{ $task->title }}
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
        <div class="card-text">
            {{ $task->description }}
        </div>
        <hr>
        <div class="card-text">
            Participantes da tarefa:
            <ul id="participantes">
                @foreach ($task->users as $user)
                <li id="user{{ $user->id }}">{{ $user->name }} ({{ $user->email }}) <a class="A_removeTaskUser" data-task="{{ $task->id }}" data-user="{{ $user->id }}" style="text-decoration: none;color:red;cursor: pointer;font-weight: 900" title="Remover participante">&times</a></li>
                @endforeach
            </ul>
        </div>
        <div class="card-text">
            Inclua outros Participantes
            <div class="A_msg"></div>
            <div class="row">
                <div class="col-md-10">
                    <input type="email" name="email" id="A_emailParticipante" class="form-control" placeholder="email">
                </div>
                    <d class="btn btn-success col A_incluirParticipante" data-task="{{ $task->id }}" style="cursor: pointer;">Incluir</d>
            </div>
        </div>

    </div>
    <div class="card-footer">
        @switch ($task->status)
        @case(1)
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Em andamento
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $task->id }}" data-status="2">Concluído</a></li>
                <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $task->id }}" data-status="3">Cancelado</a></li>
            </ul>
        </div>
        @break
        @case(2)
        <div class="btn-group">
            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Concluído
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $task->id }}" data-status="1">Em andamento</a></li>
                <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $task->id }}" data-status="3">Cancelado</a></li>
            </ul>
        </div>'
        @break
        @case(3)
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Cancelado
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $task->id }}" data-status="1">Em andamento</a></li>
                <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $task->id }}" data-status="2">Concluído</a></li>
            </ul>
        </div>
        @break
        @default
        <div class="btn-group">
            <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Desconhecido
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $task->id }}" data-status="1">Em andamento</a></li>
                <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $task->id }}" data-status="2">Concluído</a></li>
                <li><a class="dropdown-item A_taskStatus" style="cursor:pointer" data-task="{{ $task->id }}" data-status="3">Cancelado</a></li>
            </ul>
        </div>
        @endswitch
    </div>
</div>
@endsection