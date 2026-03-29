<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Herramienta;
use Carbon\Carbon;


class PrestamoController extends Controller
{
    public function store(Request $request)
    {

        $herramienta = Herramienta::find($request->id_herramienta);

        // Verificar si hay suficiente material
        if ($herramienta->cantidad < $request->cantidad) {
            return redirect()->back()->with('error', 'No hay suficientes herramientas disponibles');
        }

        Prestamo::create([
            'id_persona' => $request->id_persona,
            'id_herramienta' => $request->id_herramienta,
            'cantidad' => $request->cantidad,
            'fecha_prestamo' => Carbon::today(),
            'hora_prestamo' => Carbon::now()->format('H:i:s'),
            'fecha_devolucion' => $request->fecha_devolucion,
            'estado' => 0,
            'devolucion_real' => null
        ]);

        // RESTAR HERRAMIENTAS
        $herramienta->cantidad -= $request->cantidad;
        $herramienta->save();

        return redirect()->route('prestamos')->with('success', 'Préstamo registrado');
    }
    public function completarPrestamo(Request $request, $id)
    {

        $prestamo = Prestamo::findOrFail($id);

        $prestamo->estado = 1;
        $prestamo->devolucion_real = Carbon::today();
        $prestamo->comentarios = $request->comentarios;
        $prestamo->save();

        // SUMA LA HERRAMIENTA
        $herramienta = Herramienta::find($prestamo->id_herramienta);
        $herramienta->cantidad += $prestamo->cantidad;
        $herramienta->save();

        return redirect()->route('prestamos')->with('success', 'Herramienta devuelta');
    }
}
