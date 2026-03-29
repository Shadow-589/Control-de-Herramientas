<link rel="stylesheet" href="{{ asset('css/menu.css') }}">
<link rel="icon" href="{{ asset('img/configuraciones.png') }}">
@php
    use Carbon\Carbon;

    $vencidos = \App\Models\Prestamo::with(['persona', 'herramienta'])
        ->where('estado', 0) // no devuelto
        ->whereDate('fecha_devolucion', '<', Carbon::now())
        ->take(4)
        ->get();

    $totalVencidos = \App\Models\Prestamo::where('estado', 0)
        ->whereDate('fecha_devolucion', '<', Carbon::now())
        ->count();
@endphp

<nav class="navbar navbar-dark bg-danger px-3 d-flex align-items-center">

    <!-- Botón menú -->
    <button class="btn btn-danger menu-btn" onclick="toggleSidebar()">
        ☰
    </button>

    <!-- Título centrado -->
    <span class="navbar-brand mx-auto">
        CONTROL DE HERRAMIENTAS
    </span>

    <!-- Iconos derecha -->
    <div class="d-flex align-items-center ms-auto">
        <!-- BOTÓN CAMPANITA -->
        <button class="btn text-white me-2 position-relative" onclick="toggleNotiMenu()">
            <i class="bi bi-bell fs-4"></i>
            @if ($totalVencidos > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $totalVencidos }}
                </span>
            @endif
        </button>

        <!-- BOTÓN USUARIO -->
        <button class="btn text-white user-btn" onclick="toggleUserMenu()">

            @if (session('usuario')->foto)
                <img src="{{ asset('storage/' . session('usuario')->foto) }}" class="rounded-circle" width="40"
                    height="40" style="object-fit: cover;">
            @else
                <i class="bi bi-person-circle fs-4"></i>
            @endif

        </button>

    </div>
</nav>
<!--TARJETA CAMPANITA-->
<div id="notiMenu" class="noti-menu d-none">

    <div class="noti-card">

        <h6 class="mb-3">🔔 Préstamos vencidos</h6>

        @forelse($vencidos as $v)
            <div class="noti-item mb-2 p-2 border rounded">

                <strong>{{ $v->herramienta->nombre }}</strong><br>

                <small>
                    {{ $v->persona->nombre }} {{ $v->persona->apaterno }}
                </small><br>

                <span class="text-danger">
                    Vencido: {{ \Carbon\Carbon::parse($v->fecha_devolucion)->format('d/m/Y') }}
                </span>

            </div>

        @empty
            <p class="text-muted">No hay préstamos vencidos</p>
        @endforelse

        <a href="{{ route('notificaciones') }}" class="btn btn-sm btn-outline-danger">
            Ver todas
        </a>

    </div>
</div>
<!--TARJETA USUARIO-->
<div id="userMenu" class="user-menu">

    <div class="user-card">

        <div class="d-flex justify-content-between align-items-start">

            <!-- INFO -->
            <div>
                <p><strong>Nombre:</strong> {{ session('usuario')->nombre }}</p>
                <p><strong>Correo:</strong> {{ session('usuario')->correo }}</p>
                <p><strong>Teléfono:</strong> {{ session('usuario')->telefono }}</p>

                <a href="/logout" class="btn btn-danger mt-2">
                    Cerrar Sesión
                </a>
            </div>

            <!-- FOTO -->
            <div>
                @if (session('usuario')->foto)
                    <img src="{{ asset('storage/' . session('usuario')->foto) }}" class="rounded-circle" width="140"
                        height="140" style="object-fit: cover;">
                @else
                    <i class="bi bi-person-circle text-danger" style="font-size: 90px;"></i>
                @endif
            </div>

        </div>

    </div>
</div>

<!-- SIDEBAR -->
<div id="sidebar">
    <h2 class="text-center text-white py-3 border-bottom"><i class="bi bi-list"></i> MENU</h2>

    <ul class="nav flex-column mt-4">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('prestamos') }}">
                Préstamos <i class="bi bi-calendar-check"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('herramientas') }}">
                Herramientas <i class="bi bi-tools"></i>
            </a>
        </li>

        {{-- SOLO ADMIN --}}
        @if (session('usuario')->tipo == 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('control') }}">
                    Añadir Personal <i class="bi bi-person-add"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('backup') }}">
                    Backup <i class="bi bi-file-arrow-down"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('usuarios') }}">
                    Añadir Usuarios <i class="bi bi-person-vcard-fill"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('reportes') }}">
                    Reportes <i class="bi bi-newspaper"></i>
                </a>
            </li>
        @endif

    </ul>
</div>

<!-- JS -->
<script src="{{ asset('js/menu.js') }}"></script>
