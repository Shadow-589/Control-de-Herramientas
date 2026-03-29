<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use Illuminate\Http\Request;

class HerramientaController extends Controller
{
    public function index()
    {
        $herramientas = Herramienta::paginate(5);
        return view('herramientas', compact('herramientas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:1,2',
            'datos' => 'nullable|string',
            'cantidad' => 'required|integer|min:0',
            'estado_herramienta' => 'nullable|string|max:255',
        ]);

        Herramienta::create($data);

        return redirect()->route('herramientas')
            ->with('success', 'Herramienta añadida correctamente.');
    }

    public function edit($id)
    {
        $herramienta = Herramienta::findOrFail($id);
        return view('herramientas_edit', compact('herramienta')); // crea esta vista o adapta
    }

    public function update(Request $request, $id)
    {
        $herramienta = Herramienta::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:1,2',
            'datos' => 'nullable|string',
            'cantidad' => 'required|integer|min:0',
            'estado_herramienta' => 'nullable|string|max:255',
        ]);

        $herramienta->update($data);

        return redirect()->route('herramientas')
            ->with('success', 'Herramienta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $herramienta = Herramienta::findOrFail($id);
        $herramienta->delete();

        return redirect()->route('herramientas')
            ->with('success', 'Herramienta eliminada.');
    }
}
