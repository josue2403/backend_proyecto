<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\{RegisterRequest,
                            LoginRequest};
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
{
    try {
        // Intenta crear un nuevo usuario
        $user = User::create([
            'ci' => $request->ci,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'rol_id' => $request->rol_id, // Debe ser validado como existente en la tabla 'rol'
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
            'country' => $request->country,
            'city' => $request->city,
            'urlPhoto' => $request->urlPhoto,
            'password' => bcrypt($request->password), // Contraseña encriptada
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Generar el token JWT
        $token = JWTAuth::fromUser($user);

        // Retorna la respuesta con el usuario y el token
        return response()->json(compact('user', 'token'), 201);
    } catch (\Exception $e) {
        // Captura cualquier excepción y retorna un error
        return response()->json(['error' => 'Error al registrar usuario: ' . $e->getMessage()], 500);
    }
}

    public function login(LoginRequest $request){
        
        $credentials = $request->only('email', 'password');

        //Verificación de credenciales
        if (!$token = JWTAuth::attempt($credentials)){
            return response()->json(['error' => 'invalid_credentials'], 401);
        }

        $user = User::where('email', $request->email)->first();

        //Devuelve usuario y token
        return response()->json(compact('user', 'token'), 201);
    }
}
