<?php

use Illuminate\Support\Facades\Route;
use App\Models\Personal;
use App\Models\Prestamo;
use App\Models\Herramienta;
use App\Http\Controllers\HerramientaController;
use App\Http\Controllers\PersonalController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportesExport;

Route::middleware('auth.custom')->group(function () {

    Route::get('/control', function () {
        $personas = Personal::paginate(5);
        return view('control', compact('personas'));
    })->name('control');

    // RUTAS NORMALES
    Route::post('/personas', [PersonalController::class, 'store'])->name('personas.store');
    Route::put('/personas/{id}', [PersonalController::class, 'update'])->name('personas.update');
    Route::delete('/personas/{id}', function ($id) {
        Personal::findOrFail($id)->delete();
        return redirect()->route('control');
    })->name('personas.destroy');

    // PRESTAMOS
    Route::get('/prestamos', function () {
        $prestamos = Prestamo::with(['persona', 'herramienta'])->paginate(7);

        $personas = Personal::all();
        $herramientas = Herramienta::all();

        return view('prestamos', compact('prestamos', 'personas', 'herramientas'));
    })->name('prestamos');

    Route::post('/prestamos', [PrestamoController::class, 'store'])->name('prestamos.store');
    Route::put('/prestamos/devolver/{id}', [PrestamoController::class, 'devolver'])->name('prestamos.devolver');
    Route::put('/prestamos/completar/{id}', [PrestamoController::class, 'completarPrestamo'])->name('prestamos.completar');

    // HERRAMIENTAS
    Route::get('/herramientas', [HerramientaController::class, 'index'])->name('herramientas');
    Route::post('/herramientas', [HerramientaController::class, 'store'])->name('herramientas.store');
    Route::put('/herramientas/{id}', [HerramientaController::class, 'update'])->name('herramientas.update');
    Route::delete('/herramientas/{id}', [HerramientaController::class, 'destroy'])->name('herramientas.destroy');

    // QR
    Route::get('/herramienta/{id}/qr', function ($id) {
        return response(
            QrCode::size(200)->generate("HERRAMIENTA-$id"),
            200
        )->header('Content-Type', 'image/svg+xml');
    });

    Route::get('/persona/{id}/qr', function ($id) {
        return response(
            QrCode::size(200)->generate("PERSONA-$id"),
            200
        )->header('Content-Type', 'image/svg+xml');
    });
    Route::get('/notificaciones', function () {

        $notificaciones = \App\Models\Prestamo::with(['persona', 'herramienta'])
            ->where('estado', 0) // no devuelto
            ->whereDate('fecha_devolucion', '<', now()) // vencido
            ->orderBy('fecha_devolucion', 'asc')
            ->paginate(10);

        return view('notificaciones', compact('notificaciones'));
    })->name('notificaciones');
    // SOLO ADMIN
    Route::middleware('admin')->group(function () {

        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

        Route::get('/backup', function () {

            $database = config('database.connections.mysql.database');
            $user = config('database.connections.mysql.username');
            $pass = config('database.connections.mysql.password');

            $filename = "backup_" . date('Y-m-d_H-i-s') . ".sql";

            $command = "mysqldump --user={$user} --password={$pass} {$database} > " . storage_path("app/" . $filename);

            system($command);

            return response()->download(storage_path("app/" . $filename))->deleteFileAfterSend(true);
        })->name('backup');
        //Reportes
        Route::get('/reportes', function () {

            $filtro = request('filtro');
            $query = Prestamo::with(['persona', 'herramienta']);
            if ($filtro == 'hoy') {
                $query->whereDate('fecha_prestamo', now()->toDateString());
            }
            if ($filtro == 'semana') {
                $query->whereBetween('fecha_prestamo', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
            }
            if ($filtro == 'mes') {
                $query->whereMonth('fecha_prestamo', now()->month)
                    ->whereYear('fecha_prestamo', now()->year);
            }
            $reportes = $query->paginate(7);
            $reportes->appends(request()->query());
            return view('reportes', compact('reportes'));
        })->name('reportes');
        //Reportes Descargas en excel

        Route::get('/reportes/excel', function () {
            $filtro = request('filtro');
            return Excel::download(new ReportesExport($filtro), 'reportes.xlsx');
        })->name('reportes.excel');
    });
});
Route::get('/', function () {
    return view('inicio');
});
/**
 * RUTAS PUBLICAS
 */
Route::get('/login', function () {
    if (session()->has('usuario')) {
        return redirect()->route('prestamos');
    }
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logout', function () {
    session()->flush(); // borra toda la sesión
    session()->invalidate(); // invalida la sesión
    session()->regenerateToken(); // seguridad

    return redirect('/login');
});
