<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="icon" href="{{ asset('img/configuraciones.png') }}">
    <title>Login</title>
</head>

<body>
    @error('login')
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
    @enderror
    <nav class="navbar navbar-dark bg-danger">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">
                Control de Herramientas
            </span>
        </div>
    </nav>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->
            <h2 class="active"> Bienvenido </h2>
            <div class="mt-4"></div>
            <!-- Icon -->
            <div class="fadeIn first">
                <img src="{{ asset('img/usuario.png') }}" id="icon" alt="User Icon">

            </div>
            <div class="mt-4"></div>
            <!-- Login Form -->
            <div class="mx-auto mt-4" style="max-width: 350px;">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <input type="text" name="correo" class="form-control mb-3 fadeIn second" placeholder="Usuario"
                        required>

                    <input type="password" name="password" class="form-control mb-3 fadeIn third"
                        placeholder="Contraseña" required>

                    <input type="submit" class="btn btn-danger w-90 fadeIn fourth" value="Iniciar">
                </form>
            </div>

            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="#" data-bs-toggle="modal" data-bs-target="#modalPassword">
                    Has olvidado tu contraseña?
                </a>
            </div>

        </div>
    </div>
    <!--INICIAN LOS MODALES -->

    <!--INICIA EL MODAL HAS OLVIDADO LA CONTRASEÑA?-->
    <div class="modal fade" id="modalPassword" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow">

                <div class="modal-header">
                    <h5 class="modal-title">Recuperar contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>
                        Si olvidaste tu contraseña, comunícate con el administrador
                        del sistema para que pueda restablecerla.
                    </p>

                    <p class="fw-bold text-center">
                        Administrador: Mtro. Vicente Coria Rojas
                    </p>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" data-bs-dismiss="modal">
                        Aceptar
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!--TERMINA EL MODAL HAS OLVIDADO LA CONTRASEÑA?-->

    <!--Scritp --->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
