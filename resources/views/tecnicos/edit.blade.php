@extends('layouts.app')

@section('title', 'Editar Técnico')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Técnico</h1>

    <form action="{{ route('tecnicos.update', $tecnico) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nombre *</label>
            <input type="text" name="nombre" value="{{ old('nombre', $tecnico->nombre) }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                   required>
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Número de Empleado *</label>
            <input type="text" name="numero_empleado" value="{{ old('numero_empleado', $tecnico->numero_empleado) }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                   placeholder="ej: EMP001"
                   required>
            @error('numero_empleado')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Departamento *</label>
            <select name="departamento" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                <option value="Corte" {{ old('departamento', $tecnico->departamento) === 'Corte' ? 'selected' : '' }}>✂️ Corte</option>
                <option value="Costura" {{ old('departamento', $tecnico->departamento) === 'Costura' ? 'selected' : '' }}>🧵 Costura</option>
                <option value="Extras" {{ old('departamento', $tecnico->departamento) === 'Extras' ? 'selected' : '' }}>⭐ Extras</option>
            </select>
            @error('departamento')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="activo" value="1" {{ old('activo', $tecnico->activo) ? 'checked' : '' }} 
                       class="mr-2">
                <span class="text-gray-700 font-semibold">Activo</span>
            </label>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Actualizar
            </button>
            <a href="{{ route('tecnicos.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
