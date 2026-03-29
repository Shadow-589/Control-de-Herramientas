<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notificaciones</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>

<body>
    @include('menu')
    <div id="overlay" onclick="toggleSidebar()"></div>
    <div class="container mt-4">
        <h4 class="mb-4"><i class="bi bi-bell"></i> Préstamos vencidos</h4>
        <div class="row">
            @forelse($notificaciones as $n)
                <div class="col-md-4 mb-3">
                    <div class="card border-danger shadow">
                        <div class="card-body">
                            <h5 class="card-title text-danger">
                                {{ $n->herramienta->nombre }}
                                <span class="badge bg-danger">Vencido</span>
                            </h5>
                            <p class="mb-1">
                                <strong>
                                    {{ $n->persona->nombre }} {{ $n->persona->apaterno }}
                                </strong>
                            </p>
                            <p class="text-danger mb-0">
                                Vencido:
                                {{ \Carbon\Carbon::parse($n->fecha_devolucion)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-success text-center">
                        No hay préstamos vencidos
                    </div>
                </div>
            @endforelse
        </div>
        <!-- PAGINADOR -->
        <div class="d-flex justify-content-center mt-3">
            {{ $notificaciones->links() }}
        </div>
    </div>
    <!-- JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
