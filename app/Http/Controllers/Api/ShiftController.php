<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Shift;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ShiftController extends Controller
{
    public function getShiftById($id)
    {
        // Recuperar los detalles del turno por ID
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json(['message' => 'Turno no encontrado'], 404);
        }

        return response()->json($shift);
    }

    public function reserveShift(Request $request, $id)
    {
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json(['message' => 'Turno no encontrado'], 404);
        }

        if ($shift->state !== 'Disponible') {
            return response()->json(['message' => 'Este turno ya no está disponible'], 400);
        }

        $shift->state = 'Reservado';
        $shift->save();

        // Aquí puedes agregar lógica para registrar el pago con la tarjeta seleccionada

        return response()->json(['message' => 'Turno reservado con éxito']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'company_id' => 'nullable|exists:company,id',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'state' => 'nullable|string',
            'urlPhoto' => 'nullable|url',
        ]); 

        try {
            $shift = Shift::create($validated);

            return response()->json([
                'message' => 'Turno creado exitosamente.',
                'data' => $shift,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el turno.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeMultiple(Request $request)
    {
        $shifts = $request->input('shifts');

        try {
            foreach ($shifts as $shiftData) {
                Shift::create($shiftData); // Crear cada turno
            }
            return response()->json(['message' => 'Turnos creados exitosamente'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear turnos', 'details' => $e->getMessage()], 500);
        }
    }

    public function getAuthenticatedUserShifts(Request $request)
{
    try {
        // Obtener el usuario autenticado
        $user = JWTAuth::parseToken()->authenticate();

        // Obtener los IDs de las compañías asociadas al usuario autenticado
        $companies = Company::where('user_id', $user->id)->pluck('id'); // Solo IDs

        if ($companies->isEmpty()) {
            return response()->json(['message' => 'No tienes compañías asociadas'], 404);
        }

        // Obtener los turnos asociados a esas compañías
        $shifts = Shift::whereIn('company_id', $companies)->get();

        return response()->json(['shifts' => $shifts], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener los turnos', 'details' => $e->getMessage()], 500);
    }
}


    

    
}
