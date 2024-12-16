<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{

    // Obtener todas las tarjetas del usuario autenticado
    public function index()
    {
        $userId = auth()->id();
        $cards = Card::where('user_id', $userId)->get();

        return response()->json($cards);
    }

    // Crear una nueva tarjeta
    public function store(Request $request)
    {
        $userId = auth()->id();

        // Validar los datos de entrada
        $validatedData = $request->validate([
            'owner' => 'required|string|max:255',
            'acc_num' => 'required|string|max:20', 
            'end_month' => 'required|digits:2',
            'end_year' => 'required|digits:4',
            'cvv' => 'required|digits:3',
        ]);        

        // Crear la tarjeta en la base de datos
        $card = Card::create([
            'user_id' => $userId,
            'owner' => $validatedData['owner'],
            'acc_num' => $validatedData['acc_num'],
            'end_month' => $validatedData['end_month'],
            'end_year' => $validatedData['end_year'],
            'cvv' => $validatedData['cvv'],
        ]);

        return response()->json($card, 201);
    }

    // Método para eliminar una tarjeta
    public function destroy($id)
    {
        // Obtener la tarjeta por su ID
        $card = Card::find($id);

        // Verificar si la tarjeta existe
        if (!$card) {
            return response()->json(['message' => 'Tarjeta no encontrada'], 404);
        }

        // Verificar si la tarjeta pertenece al usuario autenticado
        if ($card->user_id !== auth()->id()) {
            return response()->json(['message' => 'No tienes permisos para eliminar esta tarjeta'], 403);
        }

        // Eliminar la tarjeta
        $card->delete();

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'Tarjeta eliminada correctamente'], 200);
    }

}
