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

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Código *</label>
            <input type="text" name="codigo" value="{{ old('codigo') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                   required>
            @error('codigo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Descripción</label>
            <textarea name="descripcion" rows="3" 
                      class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Categoría</label>
            <input type="text" name="categoria" value="{{ old('categoria') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                   placeholder="Ej: Eléctrica, Mecánica, Medición">
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
