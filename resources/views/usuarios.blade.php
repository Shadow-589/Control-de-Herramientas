<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuarios</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <h4 class="mb-0">Usuarios</h4>
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
                        <th>Telefono</th>
                        <th>Tipo</th>
                        <th>Usuario</th>
                        <th>Foto</th>
                        <th>Contraseña</th>
                        <th>Opciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->a_paterno }}</td>
                            <td>{{ $usuario->a_materno }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>{{ $usuario->tipo }}</td>
                            <td>{{ $usuario->correo }}</td>
                            <td>
                                @if ($usuario->foto)
                                    <img src="{{ asset('storage/' . $usuario->foto) }}" width="50">
                                @endif
                            </td>
                            <td>********</td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                    onclick="editarUsuario(
                                        {{ $usuario->id }},
                                        '{{ $usuario->nombre }}',
                                        '{{ $usuario->a_paterno }}',
                                        '{{ $usuario->a_materno }}',
                                        '{{ $usuario->telefono }}',
                                        '{{ $usuario->correo }}',
                                        '{{ $usuario->tipo }}',
                                        '{{ $usuario->foto }}')"
                                    data-bs-toggle="modal" data-bs-target="#modalEditarUsuario">
                                    Editar
                                </button>

                                <button class="btn btn-danger btn-sm" onclick="abrirModalEliminar({{ $usuario->id }})"
                                    data-bs-toggle="modal" data-bs-target="#modalEliminar">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3 d-flex justify-content-center">
                {{ $usuarios->links() }}
            </div>

            <!--INICIA EL MODAL AGREGAR USUARIOS-->
            <div class="modal fade" id="modalAgregarPersona" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">

                        <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- HEADER -->
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Añadir usuario</h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <!-- BODY -->
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" required
                                            value="{{ old('nombre') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido Paterno</label>
                                        <input type="text" name="a_paterno" class="form-control" required
                                            value="{{ old('a_paterno') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido Materno</label>
                                        <input type="text" name="a_materno" class="form-control" required
                                            value="{{ old('a_materno') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" name="telefono" class="form-control"
                                            value="{{ old('telefono') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Usuario</label>
                                        <input type="text" name="correo" class="form-control"
                                            value="{{ old('correo') }}" placeholder="Nombre de usuario" required>
                                        @error('correo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tipo</label>
                                        <select name="tipo" class="form-select" required>
                                            <option value="">Seleccionar tipo</option>
                                            <option value="admin" {{ old('tipo') == 'admin' ? 'selected' : '' }}>
                                                Administrador
                                            </option>
                                            <option value="usuario" {{ old('tipo') == 'usuario' ? 'selected' : '' }}>
                                                Usuario
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <input type="password" name="password" class="form-control" required>
                                        <small class="text-muted">
                                            Mínimo 6 caracteres. Puede incluir letras, números y símbolos.
                                        </small>
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Foto</label>
                                        <input type="file" name="foto" id="inputFoto" class="form-control"
                                            accept="image/png, image/jpeg">
                                        <!-- PREVISUALIZACIÓN -->
                                        <div class="mt-2 text-center">
                                            <img id="previewFoto" src="" alt="Vista previa"
                                                style="max-width: 150px; display: none; border-radius: 10px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FOOTER -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--TERMINA EL MODAL AGREGAR USUARIOS-->

            <!--INICIA EL MODAL EDITAR USUARIOS-->
            <div class="modal fade" id="modalEditarUsuario" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <form id="formEditar" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header bg-warning">
                                <h5 class="modal-title">Editar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" id="edit_id">
                                    <div class="col-md-6 mb-3">
                                        <label>Nombre</label>
                                        <input type="text" id="edit_nombre" name="nombre" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Apellido Paterno</label>
                                        <input type="text" id="edit_ap" name="a_paterno" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Apellido Materno</label>
                                        <input type="text" id="edit_am" name="a_materno" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Teléfono</label>
                                        <input type="text" id="edit_tel" name="telefono" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Usuario</label>
                                        <input type="text" id="edit_correo" name="correo" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Tipo</label>
                                        <select id="edit_tipo" name="tipo" class="form-select">
                                            <option value="admin">Administrador</option>
                                            <option value="usuario">Usuario</option>
                                        </select>
                                    </div>
                                    <!-- PASSWORD OPCIONAL -->
                                    <div class="col-md-6 mb-3">
                                        <label>Nueva Contraseña</label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Dejar vacío para no cambiar">
                                        <small class="text-muted">
                                            Mínimo 6 caracteres. Puede incluir letras, números y símbolos.
                                        </small>
                                    </div>
                                    <!-- FOTO -->
                                    <div class="col-md-6 mb-3">
                                        <label>Foto</label>
                                        <input type="file" id="edit_foto" name="foto" class="form-control"
                                            accept="image/png, image/jpeg">

                                        <div class="mt-2 text-center">
                                            <img id="previewEditar"
                                                style="width:120px; height:120px; object-fit:cover; border-radius:50%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancelar
                                </button>
                                <button class="btn btn-warning">Actualizar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!--TERMINA EL MODAL EDITAR USUARIOS-->

            <!--INICIA EL MODAL ELIMINAR USUARIOS-->
            <div class="modal fade" id="modalEliminar" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Confirmar Eliminación</h5>
                            <button type="button" class="btn-close btn-close-white"
                                data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body text-center">
                            <p>¿Estás seguro que deseas eliminar este Usuario?</p>
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
            <!--TERMINA EL MODAL ELIMINAR USUARIOS-->
            <!-- JS -->
            <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
            <script src="{{ asset('js/sidebar.js') }}"></script>
            <script src="{{ asset('js/foto.js') }}"></script>
            <script src="{{ asset('js/UserEdit.js') }}"></script>
            <!-- Detector de errores -->
            @if ($errors->crear->any())
                <script>
                    var modal = new bootstrap.Modal(document.getElementById('modalAgregarPersona'));
                    modal.show();
                </script>
            @endif

            @if ($errors->editar->any())
                <script>
                    var modal = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));
                    modal.show();
                </script>
            @endif
            @if (session('edit_id'))
                <script>
                    let id = "{{ session('edit_id') }}";

                    let usuarios = @json($usuarios);

                    let usuario = usuarios.data.find(u => u.id == id);

                    if (usuario) {
                        editarUsuario(
                            usuario.id,
                            usuario.nombre,
                            usuario.a_paterno,
                            usuario.a_materno,
                            usuario.telefono,
                            usuario.correo,
                            usuario.tipo,
                            usuario.foto
                        );
                    }
                </script>
            @endif

</body>

</html>
