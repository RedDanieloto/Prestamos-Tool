@extends('layouts.app')

@section('title', 'Dashboard - Gestión de Préstamos')

@section('content')
<div class="mb-6 flex justify-end">
    <button id="start-tour" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
        📖 Iniciar Tutorial
    </button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Panel de Herramientas Disponibles -->
    <div id="herramientas-panel" class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">🔧 Herramientas Disponibles</h2>
        <div id="herramientas-disponibles" class="space-y-2 min-h-[200px]">
            @forelse($herramientas as $herramienta)
                <div class="herramienta-item bg-blue-50 border border-blue-200 p-3 rounded cursor-move hover:shadow-md transition"
                     data-id="{{ $herramienta->id }}">
                    <div class="font-semibold">{{ $herramienta->nombre }}</div>
                    <div class="text-sm text-gray-600">Código: {{ $herramienta->codigo }}</div>
                    @if($herramienta->categoria)
                        <div class="text-xs text-gray-500">{{ $herramienta->categoria }}</div>
                    @endif
                </div>
            @empty
                <div class="text-gray-500 text-center py-8">
                    No hay herramientas disponibles
                </div>
            @endforelse
        </div>
    </div>

    <!-- Panel de Técnicos -->
    <div id="tecnicos-panel" class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">👤 Técnicos Activos</h2>
        <div class="space-y-2">
            @forelse($tecnicos as $tecnico)
                <div class="tecnico-zone bg-green-50 border-2 border-dashed border-green-300 p-4 rounded min-h-[80px]"
                     data-tecnico-id="{{ $tecnico->id }}">
                    <div class="font-semibold text-gray-800">{{ $tecnico->nombre_completo }}</div>
                    <div class="text-sm text-gray-600">{{ $tecnico->email }}</div>
                    @if($tecnico->departamento)
                        <div class="text-xs text-gray-500">{{ $tecnico->departamento }}</div>
                    @endif
                    <div class="herramientas-asignadas mt-2 space-y-1"></div>
                </div>
            @empty
                <div class="text-gray-500 text-center py-8">
                    No hay técnicos activos
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Tabla de Préstamos Activos -->
<div id="prestamos-activos" class="bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-xl font-bold mb-4 text-gray-800">📋 Préstamos Activos</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Técnico</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Herramienta</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Préstamo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody id="prestamos-list" class="divide-y divide-gray-200">
                @forelse($prestamos as $prestamo)
                    <tr data-prestamo-id="{{ $prestamo->id }}">
                        <td class="px-6 py-4">{{ $prestamo->tecnico->nombre_completo }}</td>
                        <td class="px-6 py-4">{{ $prestamo->herramienta->nombre }}</td>
                        <td class="px-6 py-4">{{ $prestamo->fecha_prestamo->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4">{{ $prestamo->notas ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <button onclick="devolverHerramienta({{ $prestamo->id }})" 
                                    class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                Devolver
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No hay préstamos activos
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
