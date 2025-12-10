@extends('layouts.app')

@section('title', 'Técnicos')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800"><i class="bi bi-person-fill text-blue-600"></i> Gestión de Técnicos</h1>
        <a href="{{ route('tecnicos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="bi bi-plus-circle"></i> Nuevo Técnico
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Empleado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Departamento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($tecnicos as $tecnico)
                    <tr>
                        <td class="px-6 py-4">{{ $tecnico->nombre }}</td>
                        <td class="px-6 py-4">{{ $tecnico->numero_empleado }}</td>
                        <td class="px-6 py-4">
                            @if($tecnico->departamento === 'Corte')
                                <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs"><i class="bi bi-scissors"></i> Corte</span>
                            @elseif($tecnico->departamento === 'Costura')
                                <span class="bg-pink-100 text-pink-800 px-2 py-1 rounded text-xs"><i class="bi bi-scissors"></i> Costura</span>
                            @else
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs"><i class="bi bi-star-fill"></i> Extras</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($tecnico->activo)
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Activo</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('tecnicos.edit', $tecnico) }}" 
                               class="text-blue-600 hover:text-blue-800"><i class="bi bi-pencil"></i> Editar</a>
                            <form action="{{ route('tecnicos.destroy', $tecnico) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('¿Está seguro de eliminar este técnico?')"
                                        class="text-red-600 hover:text-red-800">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No hay técnicos registrados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
