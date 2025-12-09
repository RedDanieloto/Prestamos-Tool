<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use App\Models\Tecnico;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{
    public function index()
    {
        $tecnicos = Tecnico::where('activo', true)->orderBy('nombre')->get();
        $herramientas = Herramienta::where('estado', 'disponible')->orderBy('nombre')->get();
        $prestamos = Prestamo::with(['tecnico', 'herramienta'])
            ->where('estado', 'activo')
            ->orderBy('fecha_prestamo', 'desc')
            ->get();

        return view('prestamos.index', compact('tecnicos', 'herramientas', 'prestamos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tecnico_id' => 'required|exists:tecnicos,id',
            'herramienta_id' => 'required|exists:herramientas,id',
            'notas' => 'nullable|string',
        ]);

        $validated['fecha_prestamo'] = now();
        $validated['estado'] = 'activo';

        Prestamo::create($validated);

        // Actualizar estado de herramienta
        Herramienta::find($validated['herramienta_id'])->update(['estado' => 'prestada']);

        return response()->json(['success' => true, 'message' => 'Préstamo registrado exitosamente.']);
    }

    public function devolver(Prestamo $prestamo)
    {
        $prestamo->update([
            'fecha_devolucion' => now(),
            'estado' => 'devuelto',
        ]);

        // Actualizar estado de herramienta
        $prestamo->herramienta->update(['estado' => 'disponible']);

        return response()->json(['success' => true, 'message' => 'Herramienta devuelta exitosamente.']);
    }
}
