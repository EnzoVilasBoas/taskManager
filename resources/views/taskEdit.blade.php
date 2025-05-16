@extends('layouts.admin')

@section('content')
    <h2>Tarefas</h2>

    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            Editar tarefa
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

            <form method="POST" action="{{ route('task.update', $task->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Titulo</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descricao</label>
                    <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $task->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Atualizar</button>
            </form>
        </div>
    </div>
@endsection