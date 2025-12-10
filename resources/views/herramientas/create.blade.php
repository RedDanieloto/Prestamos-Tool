@extends('layouts.app')

@section('title', 'Nueva Herramienta')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nueva Herramienta</h1>

    <form action="{{ route('herramientas.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nombre *</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                   required>
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Categoría *</label>
            <select name="categoria" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                <option value="">Seleccionar categoría</option>
                <option value="Máquinas" {{ old('categoria') === 'Máquinas' ? 'selected' : '' }}>⚙️ Máquinas</option>
                <option value="Herramientas" {{ old('categoria') === 'Herramientas' ? 'selected' : '' }}>🔨 Herramientas</option>
                <option value="Otros" {{ old('categoria') === 'Otros' ? 'selected' : '' }}>📦 Otros</option>
            </select>
            @error('categoria')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Guardar
            </button>
            <a href="{{ route('herramientas.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
