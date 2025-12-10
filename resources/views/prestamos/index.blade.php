@extends('layouts.app')

@section('title', 'Dashboard - Gestión de Préstamos')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800"><i class="bi bi-lightning-fill text-yellow-500"></i> Asignar Herramientas</h1>
    <button id="start-tour" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
        <i class="bi bi-book"></i> Tutorial
    </button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
    <!-- Panel de Herramientas con Filtro -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800"><i class="bi bi-wrench text-blue-600"></i> Herramientas</h2>
            
            <!-- Filtro de Categorías -->
            <div class="mb-4 flex gap-2 flex-wrap">
                <button onclick="filterCategory('todas')" class="category-filter px-4 py-2 rounded text-sm font-semibold bg-blue-600 text-white active">
                    Todas
                </button>
                <button onclick="filterCategory('Máquinas')" class="category-filter px-4 py-2 rounded text-sm font-semibold bg-gray-200 text-gray-700 hover:bg-gray-300">
                    <i class="bi bi-gear"></i> Máquinas
                </button>
                <button onclick="filterCategory('Herramientas')" class="category-filter px-4 py-2 rounded text-sm font-semibold bg-gray-200 text-gray-700 hover:bg-gray-300">
                    <i class="bi bi-hammer"></i> Herramientas
                </button>
                <button onclick="filterCategory('Otros')" class="category-filter px-4 py-2 rounded text-sm font-semibold bg-gray-200 text-gray-700 hover:bg-gray-300">
                    <i class="bi bi-box"></i> Otros
                </button>
            </div>

            <!-- Buscador -->
            <input type="text" id="buscar-herramientas" placeholder="<i class='bi bi-search'></i> Buscar herramienta..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded mb-4 focus:outline-none focus:border-blue-500">

            <!-- Lista de Herramientas -->
            <div id="herramientas-disponibles" class="space-y-2 max-h-[500px] overflow-y-auto">
                @forelse($herramientas as $herramienta)
                    <label class="flex items-center gap-3 bg-gradient-to-r from-blue-50 to-blue-100 border-2 border-blue-300 p-4 rounded cursor-pointer hover:shadow-lg transition hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200">
                        <input type="checkbox" 
                               class="herramienta-checkbox w-5 h-5 cursor-pointer"
                               data-id="{{ $herramienta->id }}"
                               data-nombre="{{ $herramienta->nombre }}"
                               data-categoria="{{ $herramienta->categoria }}"
                               onchange="actualizarSeleccionadas()">
                        <div class="flex-1">
                            <div class="font-bold text-gray-800">{{ $herramienta->nombre }}</div>
                            <div class="text-xs text-gray-600">
                                @if($herramienta->categoria === 'Máquinas')
                                    ⚙️ Máquinas
                                @elseif($herramienta->categoria === 'Herramientas')
                                    🔨 Herramientas
                                @else
                                    📦 Otros
                                @endif
                            </div>
                            <div class="text-xs mt-1">
                                @if($herramienta->estado === 'disponible')
                                    <span class="bg-green-200 text-green-800 px-2 py-1 rounded">✓ Disponible</span>
                                @elseif($herramienta->estado === 'prestada')
                                    <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded">⏳ Prestada</span>
                                @else
                                    <span class="bg-red-200 text-red-800 px-2 py-1 rounded">🔧 Mantenimiento</span>
                                @endif
                            </div>
                        </div>
                    </label>
                @empty
                    <div class="text-gray-500 text-center py-8">
                        No hay herramientas disponibles
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Panel de Selección y Técnicos -->
    <div class="lg:col-span-2">
        <!-- Herramientas Seleccionadas -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800"><i class="bi bi-check-square text-blue-600"></i> Seleccionadas (<span id="contador-seleccionadas">0</span>)</h2>
            <div id="herramientas-seleccionadas" class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 rounded border-2 border-dashed border-gray-300 min-h-[80px] flex flex-col gap-2 max-h-[200px] overflow-y-auto">
                <p class="text-gray-500 font-semibold text-center py-6">Selecciona herramientas</p>
            </div>
            <button onclick="limpiarSeleccionadas()" class="mt-3 w-full bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 disabled:opacity-50" id="btn-limpiar" disabled>
                <i class="bi bi-trash"></i> Limpiar selección
            </button>
        </div>

        <!-- Búsqueda de Técnicos -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800"><i class="bi bi-person text-green-600"></i> Asignar a</h2>
            
            <!-- Buscador de Empleados -->
            <input type="text" id="buscar-empleados" placeholder="Buscar empleado..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded mb-4 focus:outline-none focus:border-blue-500">
            
            <!-- Técnicos Disponibles -->
            <div class="space-y-2 max-h-[350px] overflow-y-auto">
                @forelse($tecnicos as $tecnico)
                    <button onclick="asignarHerramientas({{ $tecnico->id }}, '{{ $tecnico->nombre }}')" 
                            class="tecnico-btn w-full text-left p-4 rounded border-2 border-gray-300 hover:shadow-lg transition hover:border-blue-500 hover:bg-blue-50 disabled:opacity-50 disabled:cursor-not-allowed"
                            data-tecnico-id="{{ $tecnico->id }}"
                            data-nombre="{{ $tecnico->nombre }}"
                            data-empleado="{{ $tecnico->numero_empleado }}"
                            disabled>
                        <div class="font-bold text-gray-800">{{ $tecnico->nombre }}</div>
                        <div class="text-sm text-gray-600">#{{ $tecnico->numero_empleado }}</div>
                        <div class="text-xs mt-1">
                            @if($tecnico->departamento === 'Corte')
                                <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded">✂️ Corte</span>
                            @elseif($tecnico->departamento === 'Costura')
                                <span class="bg-pink-100 text-pink-800 px-2 py-1 rounded">🧵 Costura</span>
                            @else
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded">⭐ Extras</span>
                            @endif
                        </div>
                    </button>
                @empty
                    <div class="text-gray-500 text-center py-8">
                        No hay técnicos disponibles
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Préstamos Activos -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-2xl font-bold mb-4 text-gray-800"><i class="bi bi-list-ul text-indigo-600"></i> Préstamos Activos</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Técnico</th>
                    <th class="px-4 py-3 text-left font-semibold">Empleado</th>
                    <th class="px-4 py-3 text-left font-semibold">Dept.</th>
                    <th class="px-4 py-3 text-left font-semibold">Herramienta</th>
                    <th class="px-4 py-3 text-left font-semibold">Categoría</th>
                    <th class="px-4 py-3 text-left font-semibold">Hora</th>
                    <th class="px-4 py-3 text-center font-semibold">Acción</th>
                </tr>
            </thead>
            <tbody id="prestamos-list" class="divide-y divide-gray-200">
                @forelse($prestamos as $prestamo)
                    <tr data-prestamo-id="{{ $prestamo->id }}" class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold">{{ $prestamo->tecnico->nombre }}</td>
                        <td class="px-4 py-3">{{ $prestamo->tecnico->numero_empleado }}</td>
                        <td class="px-4 py-3">
                            @if($prestamo->tecnico->departamento === 'Corte')
                                <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs">✂️</span>
                            @elseif($prestamo->tecnico->departamento === 'Costura')
                                <span class="bg-pink-100 text-pink-800 px-2 py-1 rounded text-xs">🧵</span>
                            @else
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">⭐</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold">{{ $prestamo->herramienta->nombre }}</td>
                        <td class="px-4 py-3">
                            @if($prestamo->herramienta->categoria === 'Máquinas')
                                <span class="text-xs">⚙️ Máquinas</span>
                            @elseif($prestamo->herramienta->categoria === 'Herramientas')
                                <span class="text-xs">🔨 Herramientas</span>
                            @else
                                <span class="text-xs">📦 Otros</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 hora-prestamo" data-fecha="{{ $prestamo->fecha_prestamo->toIso8601String() }}">
                            <span class="hora-txt">{{ $prestamo->fecha_prestamo->format('H:i') }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button onclick="devolverHerramienta({{ $prestamo->id }})" 
                                    class="bg-green-500 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-green-600">
                                Devolver
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                            Sin préstamos activos
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
// Convertir horas a zona horaria de México cuando carga la página
document.addEventListener('DOMContentLoaded', function() {
    const opcionesHora = {
        timeZone: 'America/Mexico_City',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    };
    
    document.querySelectorAll('.hora-prestamo').forEach(td => {
        const fechaISO = td.dataset.fecha;
        if (fechaISO) {
            const fecha = new Date(fechaISO);
            const horaFormato = new Intl.DateTimeFormat('es-MX', {
                hour: '2-digit',
                minute: '2-digit',
                timeZone: 'America/Mexico_City'
            }).format(fecha);
            td.querySelector('.hora-txt').textContent = horaFormato;
        }
    });
});
</script>

@endsection

