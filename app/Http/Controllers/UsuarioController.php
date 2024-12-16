<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // Mostrar todos los usuarios
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    // Crear un nuevo usuario
    public function store(Request $request)
    {
        // Validación de los datos
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'email' => 'required|email|unique:usuarios,email',
        'rol_id' => 'required|exists:rol,id',
        'contraseña' => 'required|string|min:6',
        'telefono' => 'nullable|string|max:15',
        'urlfoto' => 'nullable|url',
    ]);

    // Crear el usuario
    $usuario = Usuario::create([
        'nombre' => $validated['nombre'],
        'apellido' => $validated['apellido'],
        'email' => $validated['email'],
        'rol_id' => $validated['rol_id'],
        'contraseña' => bcrypt($validated['contraseña']),
        'telefono' => $validated['telefono'] ?? null,
        'urlfoto' => $validated['urlfoto'] ?? null,
    ]);

    return response()->json($usuario, 201); // Respuesta exitosa
    }

    // Mostrar un usuario específico
    public function show($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }

    // Actualizar un usuario existente
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $usuario->update($request->only(['nombre', 'apellido', 'email', 'rol_id', 'telefono', 'urlfoto']));

        if ($request->contraseña) {
            $usuario->contraseña = bcrypt($request->contraseña);
            $usuario->save();
        }

        return response()->json($usuario);
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $usuario->delete();
        return response()->json(['message' => 'Usuario eliminado']);
    }
}
