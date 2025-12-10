<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use Illuminate\Http\Request;

class HerramientaController extends Controller
{
    public function index()
    {
        $herramientas = Herramienta::orderBy('nombre')->get();
        return view('herramientas.index', compact('herramientas'));
    }

    public function create()
    {
        return view('herramientas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|in:Máquinas,Herramientas,Otros',
        ]);

        Herramienta::create($validated);

        return redirect()->route('herramientas.index')
            ->with('success', 'Herramienta creada exitosamente.');
    }

    public function edit(Herramienta $herramienta)
    {
        return view('herramientas.edit', compact('herramienta'));
    }

    public function update(Request $request, Herramienta $herramienta)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|in:Máquinas,Herramientas,Otros',
            'estado' => 'required|in:disponible,prestada,mantenimiento',
        ]);

        $herramienta->update($validated);

        return redirect()->route('herramientas.index')
            ->with('success', 'Herramienta actualizada exitosamente.');
    }

    public function destroy(Herramienta $herramienta)
    {
        $herramienta->delete();

        return redirect()->route('herramientas.index')
            ->with('success', 'Herramienta eliminada exitosamente.');
    }
}
