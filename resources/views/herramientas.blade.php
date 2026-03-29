<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Préstamos</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
            <h4 class="mb-0">Herramientas</h4>
            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHerramienta">
                <i class="bi bi-plus-lg"></i> Añadir
            </a>
        </div>
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Datos</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($herramientas as $herramienta)
                    <tr>
                        <td>{{ $herramienta->id }}</td>
                        <td>{{ $herramienta->nombre }}</td>
                        <td>
                            {{ $herramienta->tipo == 1 ? 'Solitaria' : 'Varias' }}
                        </td>
                        <td>{{ $herramienta->datos }}</td>
                        <td>{{ $herramienta->cantidad }}</td>
                        <td>{{ $herramienta->estado_herramienta }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm btnEditar"
                                data-id="{{ $herramienta->id }}" data-nombre="{{ $herramienta->nombre }}"
                                data-tipo="{{ $herramienta->tipo }}" data-datos="{{ $herramienta->datos }}"
                                data-cantidad="{{ $herramienta->cantidad }}"
                                data-estado="{{ $herramienta->estado_herramienta }}">
                                Editar
                            </button>
                            <div class="mt-2"></div>

                            <form action="{{ route('herramientas.destroy', $herramienta->id) }}" method="POST"
                                style="display:inline;" class="formEliminar">

                                @csrf
                                @method('DELETE')

                                <button type="button" class="btn btn-danger btn-sm btnEliminar">
                                    Eliminar
                                </button>
                            </form>
                            <div class="mt-2"></div>
                            <button class="btn btn-primary btn-sm btnQR" data-id="{{ $herramienta->id }}"
                                data-nombre="{{ $herramienta->nombre }}">
                                QR
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3 d-flex justify-content-center">
            {{ $herramientas->links() }}
        </div>
    </div>
    <!-- MODALES -->

    <!-- MODAL AGREGAR -->
    <div class="modal fade" id="modalHerramienta" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('herramientas.store') }}" method="POST">
                    @csrf

                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Añadir herramienta</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo</label>
                                <select name="tipo" class="form-select" required>
                                    <option value="1">Solitaria</option>
                                    <option value="2">Varias</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" name="cantidad" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estado</label>
                                <input type="text" name="estado_herramienta" class="form-control">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Datos</label>
                                <textarea name="datos" class="form-control"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Guardar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <!-- TERMINA MODAL AGREGAR -->

    <!-- MODAL EDITAR -->
    <div class="modal fade" id="modalEditar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="formEditar" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Editar Herramienta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Nombre</label>
                            <input type="text" name="nombre" id="edit_nombre" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Tipo</label>
                            <select name="tipo" id="edit_tipo" class="form-control">
                                <option value="1">Solitaria</option>
                                <option value="2">Varias</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Cantidad</label>
                            <input type="number" name="cantidad" id="edit_cantidad" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Estado</label>
                            <input type="text" name="estado_herramienta" id="edit_estado" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Datos</label>
                            <textarea name="datos" id="edit_datos" class="form-control"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-warning">Actualizar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <!-- TERMINA MODAL EDITAR -->
    <!-- INICIA MODAL ELIMINAR-->
    <div class="modal fade" id="modalEliminar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <p>¿Estás seguro que deseas eliminar esta herramienta?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="button" class="btn btn-danger" id="confirmarEliminar">
                        Sí, eliminar
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!--TERMINA MODAL ELIMINAR-->

    <!-- INCIA EL MODAL DEL QR-->
    <div class="modal fade" id="modalQR" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Código QR</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">

                    <div id="qrContainer"></div>

                    <br>

                    <button class="btn btn-success" id="descargarQR">
                        Descargar
                    </button>

                </div>

            </div>
        </div>
    </div>
    <!-- TERMINA EL MODAL DEL QR-->

    <!-- JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="{{ asset('js/editarHerramienta.js') }}"></script>
    <script src="{{ asset('js/qr.js') }}"></script>
</body>

</html>
