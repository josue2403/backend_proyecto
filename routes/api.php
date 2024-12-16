<?php

use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\ShiftController;
use App\Models\Card;
use App\Models\Company;
use App\Models\Shift_assigned;
use Illuminate\Http\Request;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{ UserController };
use App\Http\Controllers\Auth\AuthController;

 // Rutas públicas //
Route::prefix('auth')->group(function(){
    Route::post('register', [AuthController::class,'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['jwt.verify'])->group(function() {
    // Rutas protegidas // 
    Route::get('users', [UserController::class, 'index']);
    // Ruta para obtener compañías activas con su categoría
    Route::get('/companies', function () {
        return Company::with('category')
    ->where('state', 'Activo') // Solo empresas activas
    ->get();
    });  

    // Obtener detalles de una compañía específica por ID
    Route::get('/companies/{id}', [CompanyController::class, 'getCompanyById']);

    Route::get('/companies/{id}/shifts', [CompanyController::class, 'getShiftsByCompany']);

    // Ruta para obtener los detalles de un turno por ID
    Route::get('/shifts/{id}', [ShiftController::class, 'getShiftById']);

    Route::get('/cards', function () {
        $userId = auth()->id(); // Obtener el ID del usuario autenticado
        return Card::where('user_id', $userId)->get(); // Obtener las tarjetas asociadas al usuario
    });
    Route::put('/shifts/{id}/reserve', [ShiftController::class, 'reserveShift']);

    // Ruta para confirmar la compra y asignar el turno
    Route::put('/shifts/{id}/assign', function (Request $request, $id) {
        $userId = auth()->id();
        $shift = \App\Models\Shift::findOrFail($id);

        // Generar un código único para el turno asignado
        do {
            $code = Str::random(16);
        } while(Shift_assigned::where('code', $code)->exists()); // Reintentar si el código ya existe

        // Crear el registro de turno asignado
        $shiftAssigned = Shift_assigned::create([
            'user_id' => $userId,
            'shift_id' => $id,
            'code' => $code,
            'state' => 'Reservado por ' . $userId . ' - ' . auth()->user()->name . ' ' . auth()->user()->last_name,
        ]);

        return response()->json($shiftAssigned, 201); // Retornar el turno asignado
    });


    // Ruta de turnos asignados/reservaciones según el usuario autenticado
    Route::get('/shift_assigned', function () {
        $userId = auth()->id(); // Obtener el ID del usuario autenticado
        $assignedShifts = Shift_assigned::where('user_id', $userId)
                                        ->with('shift')
                                        ->orderBy('updated_at', 'desc') // Ordenar por updated_at en orden descendente
                                        ->get();
    
        return response()->json($assignedShifts);
    });

    Route::post('/cards', function (Request $request) {
        $userId = auth()->id(); // Obtener el ID del usuario autenticado
        $validated = $request->validate([
            'owner' => 'required|string|max:255',
            'acc_num' => 'required|string|max:255',
            'end_month' => 'required|string|max:2',
            'end_year' => 'required|string|max:4',
            'cvv' => 'required|string|max:3',
        ]);
    
        // Crear la tarjeta asociada al usuario autenticado
        $card = Card::create([
            'user_id' => $userId,
            'owner' => $validated['owner'],
            'acc_num' => $validated['acc_num'],
            'end_month' => $validated['end_month'],
            'end_year' => $validated['end_year'],
            'cvv' => $validated['cvv'],
        ]);
    
        return response()->json($card, 201); // Retornar la tarjeta creada
    });

    Route::put('/users/{id}', [UserController::class, 'update']);

    // Ruta para eliminar una tarjeta por su ID
    Route::delete('/cards/{id}', [CardController::class, 'destroy']);

    Route::get('rol/{id}', [RolController::class, 'show']);

    Route::get('/allusers', [UserController::class, 'allusers_pag']);

    Route::post('/shifts', [ShiftController::class, 'store']);

    Route::post('/shifts/multiple', [ShiftController::class, 'storeMultiple']);

    Route::get('/companiesbyId', function () {
        $user = auth()->user(); // Obtener el usuario autenticado
        return Company::where('user_id', $user->id) // Filtrar las compañías por el ID del usuario autenticado
            ->where('state', 'Activo') // Solo empresas activas
            ->with('category') // Obtener la categoría asociada
            ->get();
    });

    Route::get('/companiesbyIdAll', function () {
        $user = auth()->user(); // Obtener el usuario autenticado
        return Company::where('user_id', $user->id) // Filtrar las compañías por el ID del usuario autenticado
            ->with('category') // Obtener la categoría asociada
            ->get();
    });
    

    Route::get('/shifts/me', [ShiftController::class, 'getShiftsByUserCompany']);

    Route::get('/myshifts', [ShiftController::class, 'getAuthenticatedUserShifts']);

    Route::get('/company/{id}', [CompanyController::class, 'show']);
    // Ruta PUT para actualizar la compañía
    Route::put('/company/{id}', [CompanyController::class, 'update']);


    // Ruta para obtener categorías
    Route::get('/categories', function () {
        return \App\Models\Category::all();
    });
});