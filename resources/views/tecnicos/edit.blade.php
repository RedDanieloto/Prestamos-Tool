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
            <label class="block text-gray-700 font-semibold mb-2">Apellido *</label>
            <input type="text" name="apellido" value="{{ old('apellido', $tecnico->apellido) }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                   required>
            @error('apellido')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Email *</label>
            <input type="email" name="email" value="{{ old('email', $tecnico->email) }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                   required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $tecnico->telefono) }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
            @error('telefono')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Departamento</label>
            <input type="text" name="departamento" value="{{ old('departamento', $tecnico->departamento) }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
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
