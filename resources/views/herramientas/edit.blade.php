@extends('layouts.app')

@section('title', 'Editar Herramienta')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Herramienta</h1>

    <form action="{{ route('herramientas.update', $herramienta) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nombre *</label>
            <input type="text" name="nombre" value="{{ old('nombre', $herramienta->nombre) }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                   required>
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Código *</label>
            <input type="text" name="codigo" value="{{ old('codigo', $herramienta->codigo) }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                   required>
            @error('codigo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Descripción</label>
            <textarea name="descripcion" rows="3" 
                      class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">{{ old('descripcion', $herramienta->descripcion) }}</textarea>
            @error('descripcion')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Categoría</label>
            <input type="text" name="categoria" value="{{ old('categoria', $herramienta->categoria) }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
            @error('categoria')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Estado *</label>
            <select name="estado" 
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                    required>
                <option value="disponible" {{ old('estado', $herramienta->estado) === 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="prestada" {{ old('estado', $herramienta->estado) === 'prestada' ? 'selected' : '' }}>Prestada</option>
                <option value="mantenimiento" {{ old('estado', $herramienta->estado) === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
            </select>
            @error('estado')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Actualizar
            </button>
            <a href="{{ route('herramientas.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
