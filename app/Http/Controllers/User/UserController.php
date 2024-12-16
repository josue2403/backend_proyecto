<?php

namespace App\Http\Controllers\User;

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
}
