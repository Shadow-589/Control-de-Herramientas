<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Control de Herramientas</title>
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
            <h4 class="mb-0">Personal</h4>
            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalAgregarPersona">
                <i class="bi bi-plus-lg"></i> Añadir
            </a>
        </div>
        <div class="container mt-3">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Tipo</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Opciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($personas as $personal)
                        <tr>
                            <td>{{ $personal->id }}</td>
                            <td>{{ $personal->nombre }}</td>
                            <td>{{ $personal->apaterno }}</td>
                            <td>{{ $personal->amaterno }}</td>
                            <td>
                                {{ $personal->tipo == 1 ? 'Estudiante' : 'Docente' }}
                            </td>

                            <td>{{ $personal->telefono }}</td>
                            <td>{{ $personal->correo_electronico }}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm btnEditarPersona"
                                    data-id="{{ $personal->id }}" data-nombre="{{ $personal->nombre }}"
                                    data-apaterno="{{ $personal->apaterno }}"
                                    data-amaterno="{{ $personal->amaterno }}" data-tipo="{{ $personal->tipo }}"
                                    data-telefono="{{ $personal->telefono }}"
                                    data-correo="{{ $personal->correo_electronico }}">
                                    Editar
                                </button>

                                <button type="button" class="btn btn-danger btn-sm btnEliminarPersona"
                                    data-id="{{ $personal->id }}">
                                    Eliminar
                                </button>
                                <button class="btn btn-primary btn-sm btnQRPersona" data-id="{{ $personal->id }}"
                                    data-nombre="{{ $personal->nombre }}">
                                    QR
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3 d-flex justify-content-center">
                {{ $personas->links() }}
            </div>
            <!-- MODALES -->
            <!-- MODAL AGREGAR -->
            <!-- MODAL AGREGAR -->
            <div class="modal fade" id="modalAgregarPersona" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">

                        <form action="{{ route('personas.store') }}" method="POST">
                            @csrf

                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Añadir Persona</h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido Paterno</label>
                                        <input type="text" name="apaterno" class="form-control" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido Materno</label>
                                        <input type="text" name="amaterno" class="form-control" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tipo</label>
                                        <select name="tipo" class="form-select" required>
                                            <option value="1">Estudiante</option>
                                            <option value="2">Docente</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" name="telefono" class="form-control">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Correo Electrónico</label>
                                        <input type="email" name="correo_electronico" class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger">Guardar</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
            <!-- FIN MODAL AGREGAR -->

            <!-- MODAL EDITAR -->
            <div class="modal fade" id="modalEditarPersona" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <form id="formEditarPersona" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-header bg-warning">
                                <h5 class="modal-title">Editar Persona</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <div class="mb-3">
                                    <label>Nombre</label>
                                    <input type="text" name="nombre" id="edit_nombre" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Apellido Paterno</label>
                                    <input type="text" name="apaterno" id="edit_apaterno" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Apellido Materno</label>
                                    <input type="text" name="amaterno" id="edit_amaterno" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Tipo</label>
                                    <select name="tipo" id="edit_tipo" class="form-select">
                                        <option value="1">Estudiante</option>
                                        <option value="2">Docente</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Teléfono</label>
                                    <input type="text" name="telefono" id="edit_telefono" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Correo Electrónico</label>
                                    <input type="email" name="correo_electronico" id="edit_correo"
                                        class="form-control">
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
            <form id="formEliminarPersona" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
            <div class="modal fade" id="modalEliminarPersona" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Confirmar Eliminación</h5>
                            <button type="button" class="btn-close btn-close-white"
                                data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body text-center">
                            <p>¿Estás seguro que deseas eliminar esta persona?</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancelar
                            </button>

                            <button type="button" class="btn btn-danger" id="confirmarEliminarPersona">
                                Sí, eliminar
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <!--TERMINA MODAL ELIMINAR-->

            <!-- INCIA EL MODAL DEL QR-->
            <div class="modal fade" id="QRPersona" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title">Código QR</h5>
                            <button type="button" class="btn-close btn-close-white"
                                data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body text-center">

                            <div id="qrContainerPersona"></div>

                            <br>

                            <button class="btn btn-success" id="descargarQRPersona">
                                Descargar
                            </button>

                        </div>

                    </div>
                </div>
            </div>
            <!-- TERMINA EL MODAL DEL QR-->
        </div>
        <!-- JS -->
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/sidebar.js') }}"></script>
        <script src="{{ asset('js/editarPersona.js') }}"></script>
        <script src="{{ asset('js/qrPersona.js') }}"></script>

</body>

</html>
