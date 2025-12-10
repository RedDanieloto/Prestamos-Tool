@extends('layouts.app')

@section('title', 'Herramientas')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800"><i class="bi bi-wrench text-blue-600"></i> Gestión de Herramientas</h1>
        <a href="{{ route('herramientas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="bi bi-plus-circle"></i> Nueva Herramienta
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($herramientas as $herramienta)
                    <tr>
                        <td class="px-6 py-4">{{ $herramienta->nombre }}</td>
                        <td class="px-6 py-4">{{ $herramienta->categoria ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($herramienta->estado === 'disponible')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs"><i class="bi bi-check-circle"></i> Disponible</span>
                            @elseif($herramienta->estado === 'prestada')
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs"><i class="bi bi-hourglass-split"></i> Prestada</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs"><i class="bi bi-tools"></i> Mantenimiento</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('herramientas.edit', $herramienta) }}" 
                               class="text-blue-600 hover:text-blue-800"><i class="bi bi-pencil"></i> Editar</a>
                            <form action="{{ route('herramientas.destroy', $herramienta) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('¿Está seguro de eliminar esta herramienta?')"
                                        class="text-red-600 hover:text-red-800">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No hay herramientas registradas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
