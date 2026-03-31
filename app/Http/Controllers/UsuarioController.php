<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::paginate(7);

        return view('usuarios', compact('usuarios'));
    }
    //agregar
    public function store(Request $request)
    {
        $request->validateWithBag('crear', [
            'nombre' => 'required|string|max:255',
            'a_paterno' => 'required|string|max:255',
            'a_materno' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'required|string|max:255|unique:usuarios,correo',
            'tipo' => 'required|in:admin,usuario',
            'password' => 'required|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png|max:2048'
        ], [
            // mensaje de usuario duplicado
            'correo.unique' => 'Este nombre de usuario ya existe'
        ]);

        // FOTO
        $rutaFoto = null;

        if ($request->hasFile('foto')) {
            $rutaFoto = $request->file('foto')->store('usuarios', 'public');
        }

        Usuario::create([
            'nombre' => $request->nombre,
            'a_paterno' => $request->a_paterno,
            'a_materno' => $request->a_materno,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'tipo' => $request->tipo,
            'foto' => $rutaFoto,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Usuario agregado correctamente');
    }
    //editar
    public function update(Request $request, $id)
    {
        session()->flash('edit_id', $id);
        $usuario = Usuario::findOrFail($id);

        $request->validateWithBag('editar', [
            'nombre' => 'required|string|max:255',
            'a_paterno' => 'required|string|max:255',
            'a_materno' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',

            'correo' => 'required|string|max:255|unique:usuarios,correo,' . $id,

            'tipo' => 'required|in:admin,usuario',
            'password' => 'nullable|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png|max:2048'
        ], [
            'correo.unique' => 'Este nombre de usuario ya existe'
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->a_paterno = $request->a_paterno;
        $usuario->a_materno = $request->a_materno;
        $usuario->telefono = $request->telefono;
        $usuario->correo = $request->correo;
        $usuario->tipo = $request->tipo;

        if ($request->password) {
            $usuario->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            $ruta = $request->file('foto')->store('usuarios', 'public');
            $usuario->foto = $ruta;
        }

        $usuario->save();

        return back()->with('success', 'Usuario actualizado correctamente');
    }
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);

        // eliminar foto si existe
        if ($usuario->foto && Storage::exists('public/' . $usuario->foto)) {
            Storage::delete('public/' . $usuario->foto);
        }

        $usuario->delete();

        return back()->with('success', 'Usuario eliminado correctamente');
    }
}
