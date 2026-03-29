<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('icons/bootstrap-icons.css') }}">
</head>

<body>

    @include('menu')

    <div id="overlay" onclick="toggleSidebar()"></div>

    <div class="container mt-4">

        <!-- TITULO + FILTROS -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Reportes</h4>

            <!-- FILTROS RÁPIDOS -->
            <div>
                <!-- HOY -->
                <a href="{{ route('reportes', ['filtro' => 'hoy']) }}"
                    class="btn btn-sm {{ request('filtro') == 'hoy' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Hoy
                </a>
                <!-- SEMANA -->
                <a href="{{ route('reportes', ['filtro' => 'semana']) }}"
                    class="btn btn-sm {{ request('filtro') == 'semana' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Semana
                </a>
                <!-- MES -->
                <a href="{{ route('reportes', ['filtro' => 'mes']) }}"
                    class="btn btn-sm {{ request('filtro') == 'mes' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Mes
                </a>
                <!-- TODOS -->
                <a href="{{ route('reportes') }}"
                    class="btn btn-sm {{ request('filtro') == null ? 'btn-secondary' : 'btn-outline-secondary' }}">
                    Todos
                </a>
            </div>
        </div>

        <!-- TABLA -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>Persona</th>
                        <th>Herramienta</th>
                        <th>cantidad</th>
                        <th>Fecha del Préstamo</th>
                        <th>Hora del Préstamo</th>
                        <th>Fecha de Devolución</th>
                        <th>Fecha de Devolución Real</th>
                        <th>Estado</th>
                        <th>Comentrios</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($reportes as $r)
                        <tr>

                            <!-- PERSONA -->
                            <td>
                                {{ $r->persona->nombre }} {{ $r->persona->apaterno }}
                            </td>

                            <!-- HERRAMIENTA -->
                            <td>
                                {{ $r->herramienta->nombre }}
                            </td>

                            <!-- CANTIDAD -->
                            <td>{{ $r->cantidad }}</td>

                            <!-- FECHA -->
                            <td>
                                {{ \Carbon\Carbon::parse($r->fecha_prestamo)->format('d/m/Y') }}
                            </td>

                            <!-- HORA -->
                            <td>
                                {{ \Carbon\Carbon::parse($r->hora_prestamo)->format('H:i') }}
                            </td>

                            <!-- FECHA DEVOLUCIÓN -->
                            <td>
                                {{ \Carbon\Carbon::parse($r->fecha_devolucion)->format('d/m/Y') }}
                            </td>

                            <!-- DEVOLUCIÓN REAL -->
                            <td>
                                {{ $r->devolucion_real ? \Carbon\Carbon::parse($r->devolucion_real)->format('d/m/Y') : '---' }}
                            </td>

                            <!-- ESTADO INTELIGENTE -->
                            <td>
                                @php
                                    $hoy = \Carbon\Carbon::now();
                                    $fechaDev = \Carbon\Carbon::parse($r->fecha_devolucion);
                                @endphp

                                @if ($r->estado == 1)
                                    @if ($r->devolucion_real && \Carbon\Carbon::parse($r->devolucion_real)->gt($fechaDev))
                                        <span class="badge bg-danger">Tarde</span>
                                    @else
                                        <span class="badge bg-success">A tiempo</span>
                                    @endif
                                @else
                                    @if ($hoy->gt($fechaDev))
                                        <span class="badge bg-danger">No devuelto</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @endif
                                @endif
                            </td>

                            <!-- COMENTARIOS -->
                            <td>{{ $r->comentarios ?? '---' }}</td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="9">No hay registros</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- IZQUIERDA -->
                <div>
                    Mostrando {{ $reportes->firstItem() }}
                    a {{ $reportes->lastItem() }}
                    de {{ $reportes->total() }} registros
                </div>
                <!-- CENTRO -->
                <div class="text-center mt-15">
                    <a href="{{ route('reportes.excel', ['filtro' => request('filtro')]) }}" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Descargar Excel
                    </a>
                </div>
                <!-- DERECHA -->
                <div>
                    {{ $reportes->links() }}
                </div>

            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>

</body>

</html>
