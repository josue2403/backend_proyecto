<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function index()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate(); // Obtiene el usuario autenticado
            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo obtener el usuario'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Verificar que el usuario autenticado sea el mismo que el que está intentando actualizar
            $user = JWTAuth::parseToken()->authenticate(); // Obtener el usuario autenticado

            if ($user->id != $id) {
                return response()->json(['error' => 'No autorizado para actualizar este usuario'], 403);
            }

            // Validar los datos de la solicitud
            $validated = $request->validate([
                'ci' => 'nullable|string|max:20|unique:users,ci,' . $id,
                'name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255|unique:users,email,' . $id,
                'phone' => 'nullable|string|max:15',
                'birthdate' => 'nullable|date',
                'urlPhoto' => 'nullable|string|max:2048', // Asegura que sea una URL válida
                // Puedes agregar más validaciones según sea necesario
            ]);

            // Actualizar los datos del usuario
            $userToUpdate = User::findOrFail($id);
            $userToUpdate->update($validated);

            return response()->json(['message' => 'Usuario actualizado con éxito', 'user' => $userToUpdate], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el usuario', 'message' => $e->getMessage()], 500);
        }
    }

    public function roles()
    {
        $user = auth()->user()->load('role');
        return response()->json($user);
    }

    public function allusers_pag(Request $request)
    {
        try {
            $users = User::paginate(10); // Paginamos los usuarios de 10 en 10
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudieron obtener los usuarios', 'message' => $e->getMessage()], 500);
        }
    }


    
}
