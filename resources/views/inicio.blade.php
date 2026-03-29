<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Control de Herramientas</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="icon" href="{{ asset('img/configuraciones.png') }}">
</head>

<body>

    <nav class="navbar navbar-dark bg-danger">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">
                Control de Herramientas
            </span>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Bienvenido</h1>
        <p>Este es el sistema de control de herramientas.</p>

        <a href="{{ route('login') }}" class="btn btn-danger">
            Entrar
        </a>
    </div>

</body>

</html>
