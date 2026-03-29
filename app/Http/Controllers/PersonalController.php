<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'apaterno' => 'required|string|max:255',
            'amaterno' => 'required|string|max:255',
            'tipo' => 'required|in:1,2',
            'telefono' => 'nullable|string|max:20',
            'correo_electronico' => 'nullable|email|max:255',
        ]);

        Personal::create($data);

        return redirect()->route('control')
            ->with('success', 'Persona añadida correctamente.');
    }
    public function update(Request $request, $id)
    {
        $persona = Personal::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'apaterno' => 'required|string|max:255',
            'amaterno' => 'required|string|max:255',
            'tipo' => 'required|in:1,2',
            'telefono' => 'nullable|string|max:20',
            'correo_electronico' => 'nullable|email|max:255',
        ]);

        $persona->update($data);

        return redirect()->route('control')
            ->with('success', 'Persona actualizada correctamente.');
    }
}
