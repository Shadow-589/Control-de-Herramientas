<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Préstamos</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

</head>

<body>
    @include('menu')

    <div id="overlay" onclick="toggleSidebar()"></div>

    <!-- TABLA -->
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Prestamos</h4>
            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalAgregarPrestamo">

                <i class="bi bi-plus-lg"></i> Añadir préstamo

            </a>

        </div>
        <div class="container mt-3">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Persona</th>
                        <th>Herramienta</th>
                        <th>cantidad</th>
                        <th>Fecha del Préstamo</th>
                        <th>Hora del Préstamo</th>
                        <th>Fecha de Devolución</th>
                        <th>Fecha de Devolución Real</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($prestamos as $prestamo)
                        <tr>
                            <td>{{ $prestamo->id }}</td>
                            <td>{{ $prestamo->persona->nombre }} {{ $prestamo->persona->apaterno }}</td>
                            <td>{{ $prestamo->herramienta->nombre }}</td>
                            <td>{{ $prestamo->cantidad }}</td>
                            <td>{{ $prestamo->fecha_prestamo }}</td>
                            <td>{{ $prestamo->hora_prestamo }}</td>
                            <td>{{ $prestamo->fecha_devolucion }}</td>
                            <td>{{ $prestamo->devolucion_real }}</td>
                            <td>
                                @php
                                    $hoy = \Carbon\Carbon::now();
                                    $fechaLimite = \Carbon\Carbon::parse($prestamo->fecha_devolucion);
                                    $fechaReal = $prestamo->devolucion_real
                                        ? \Carbon\Carbon::parse($prestamo->devolucion_real)
                                        : null;
                                @endphp

                                @if ($prestamo->estado == 1)
                                    @if ($fechaReal && $fechaReal->gt($fechaLimite))
                                        <span class="badge bg-danger">Tardío</span>
                                    @else
                                        <span class="badge bg-success">Devuelto</span>
                                    @endif
                                @else
                                    @if ($hoy->gt($fechaLimite))
                                        <span class="badge bg-danger">No devuelto</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @endif
                                @endif
                            </td>
                            <!--El boton ya no funciona cuando la devolucion ya fue completada-->
                            <td>
                                @if ($prestamo->estado == 0)
                                    <button class="btn btn-success btn-sm btnDevolver" data-id="{{ $prestamo->id }}"
                                        data-persona="{{ $prestamo->persona->nombre }} {{ $prestamo->persona->apaterno }}"
                                        data-herramienta="{{ $prestamo->herramienta->nombre }}"
                                        data-cantidad="{{ $prestamo->cantidad }}" data-bs-toggle="modal"
                                        data-bs-target="#modalDevolucion">
                                        Completar
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        Devuelto
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3 d-flex justify-content-center">
                {{ $prestamos->links() }}
            </div>
        </div>
    </div>
    <!-- INICIAN LOS MODALES-->

    <!-- INICIA MODAL AGREGAR-->
    <div class="modal fade" id="modalAgregarPrestamo" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('prestamos.store') }}" method="POST">
                    @csrf

                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Nuevo Préstamo</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Persona</label>
                                <select name="id_persona" class="form-select" required>

                                    @foreach ($personas as $personal)
                                        <option value="{{ $personal->id }}">
                                            {{ $personal->nombre }} {{ $personal->apaterno }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Herramienta</label>
                                <select name="id_herramienta" class="form-select" required>

                                    @foreach ($herramientas as $herramienta)
                                        <option value="{{ $herramienta->id }}">
                                            {{ $herramienta->nombre }}
                                        </option>
                                    @endforeach


                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Cantidad</label>
                                <input type="number" name="cantidad" class="form-control" min="1" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Fecha devolución</label>
                                <input type="date" name="fecha_devolucion" class="form-control"
                                    min="{{ date('Y-m-d') }}" required>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-dark" onclick="abrirScanner()">
                            <i class="bi bi-qr-code-scan"></i> Escanear QR
                        </button>
                        <button type="submit" class="btn btn-danger">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- TERMINA MODAL AGREGAR-->

    <!-- INICIA MODAL DEVOLUCIÓN -->
    <div class="modal fade" id="modalDevolucion" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">

                <form id="formDevolucion" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Registrar devolución</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-2">
                            <strong>Persona:</strong>
                            <span id="dev_persona"></span>
                        </div>

                        <div class="mb-2">
                            <strong>Herramienta:</strong>
                            <span id="dev_herramienta"></span>
                        </div>

                        <div class="mb-3">
                            <strong>Cantidad:</strong>
                            <span id="dev_cantidad"></span>
                        </div>

                        <div class="mb-3">
                            <label>Observaciones</label>
                            <textarea name="comentarios" class="form-control" rows="4"
                                placeholder="Ejemplo: La herramienta fue devuelta con un golpe en la parte inferior"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="submit" class="btn btn-success">
                            Confirmar devolución
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--TERMINA MODAL DEVOLUCIÓN -->

    <!--INICIA MODAL ESCANER QR -->
    <div class="modal fade" id="modalQR" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Escanear QR</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">

                    <div id="reader" style="width:100%;"></div>

                    <p class="mt-2 text-muted">
                        Escanee el QR de la persona o herramienta
                    </p>

                </div>

            </div>
        </div>
    </div>
    <!--TERMINA MODAL ESCANER QR -->
    <!--INICIA EL MODAL DE ALERTA-->
    @if (session('error'))
        <div class="modal fade show" id="modalError" style="display:block; background:rgba(0,0,0,0.5)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Herramienta agotada</h5>
                    </div>

                    <div class="modal-body text-center">
                        <h5><i class="bi bi-exclamation-triangle-fill"></i> No hay herramientas Suficientes</h5>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-dark" onclick="location.reload()">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>
    @endif
    <!--TERMINA EL MODAL DE ALERTA-->

    <!-- JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="{{ asset('js/completado.js') }}"></script>
    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
    <script src="{{ asset('js/escaner.js') }}"></script>


</body>

</html>
