<div class="d-flex flex-column p-3 bg-dark text-white" style="width: 250px; height: 100vh">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <img src="{{ asset('imagens/icon.png') }}" alt="Icon" width="80">
        <span class="fs-4">TaskMgr</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link text-white">
                Início
            </a>
        </li>
        @auth
        @if(auth()->user()->permission)
        <li>
            <a href="{{ route('usuarios') }}" class="nav-link text-white">
                Usuarios
            </a>
        </li>
        @endif
        @endauth


        <!-- Dropdown -->
        <li>
            <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#subtasks" role="button" aria-expanded="false" aria-controls="subtasks">
                Tarefas
            </a>
            <div class="collapse" id="subtasks">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                    <li><a href="{{ route('tarefas') }}" class="nav-link text-white">Cadastrar</a></li>
                    <li><a href="{{ route('tarefas.list') }}" class="nav-link text-white">Listar</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>