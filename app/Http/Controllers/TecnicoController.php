<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use Illuminate\Http\Request;

class TecnicoController extends Controller
{
    public function index()
    {
        $tecnicos = Tecnico::orderBy('nombre')->get();
        return view('tecnicos.index', compact('tecnicos'));
    }

    public function create()
    {
        return view('tecnicos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'numero_empleado' => 'required|string|unique:tecnicos',
            'departamento' => 'required|in:Corte,Costura,Extras',
        ]);

        Tecnico::create($validated);

        return redirect()->route('tecnicos.index')
            ->with('success', 'Técnico creado exitosamente.');
    }

    public function edit(Tecnico $tecnico)
    {
        return view('tecnicos.edit', compact('tecnico'));
    }

    public function update(Request $request, Tecnico $tecnico)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'numero_empleado' => 'required|string|unique:tecnicos,numero_empleado,' . $tecnico->id,
            'departamento' => 'required|in:Corte,Costura,Extras',
            'activo' => 'boolean',
        ]);

        $tecnico->update($validated);

        return redirect()->route('tecnicos.index')
            ->with('success', 'Técnico actualizado exitosamente.');
    }

    public function destroy(Tecnico $tecnico)
    {
        $tecnico->delete();

        return redirect()->route('tecnicos.index')
            ->with('success', 'Técnico eliminado exitosamente.');
    }
}
