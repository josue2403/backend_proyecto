<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function getCompanies()
    {
        $companies = Company::with('category')->get();
        return response()->json($companies);
    }

    public function getCompanyById($id)
    {
        $company = Company::with('category')->find($id);

        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        return response()->json($company);
    }

    public function getShiftsByCompany($id)
    {
        $shifts = Shift::where('company_id', $id)
            ->where('start_date', '>', Carbon::now()) // Turnos futuros
            ->get();

        return response()->json($shifts);
    }

    public function show($id)
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $company = Company::where('id', $id)
            ->where('user_id', $user->id) // Verificar que la compañía pertenezca al usuario autenticado
            ->firstOrFail();

        return response()->json($company);
    }

    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'category_id' => 'nullable|exists:category,id', // Verificar que la categoría exista
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'street1' => 'required|string|max:255',
            'street2' => 'nullable|string|max:255',
            'street3' => 'nullable|string|max:255',
            'state' => 'required|string|max:100',
            'urlPhoto' => 'nullable|url', // Verificar que sea una URL válida
        ]);

        // Verificar que la compañía exista
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        // Verificar que la compañía pertenezca al usuario autenticado
        $user = auth()->user();
        if ($company->user_id != $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Actualizar la compañía con los datos validados
        $company->update($validatedData);

        return response()->json(['message' => 'Company updated successfully', 'company' => $company]);
    }

}

