<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tecnico;
use App\Models\Herramienta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear técnicos de ejemplo - Departamento Corte
        Tecnico::create([
            'nombre' => 'Juan Pérez',
            'numero_empleado' => 'EMP001',
            'departamento' => 'Corte',
            'activo' => true,
        ]);

        Tecnico::create([
            'nombre' => 'María García',
            'numero_empleado' => 'EMP002',
            'departamento' => 'Corte',
            'activo' => true,
        ]);

        // Crear técnicos de ejemplo - Departamento Costura
        Tecnico::create([
            'nombre' => 'Carlos López',
            'numero_empleado' => 'EMP003',
            'departamento' => 'Costura',
            'activo' => true,
        ]);

        Tecnico::create([
            'nombre' => 'Ana Rodríguez',
            'numero_empleado' => 'EMP004',
            'departamento' => 'Costura',
            'activo' => true,
        ]);

        // Crear técnico - Departamento Extras
        Tecnico::create([
            'nombre' => 'Luis Martínez',
            'numero_empleado' => 'EMP005',
            'departamento' => 'Extras',
            'activo' => true,
        ]);

        // Máquinas
        Herramienta::create([
            'nombre' => 'Taladro',
            'categoria' => 'Máquinas',
            'estado' => 'disponible',
        ]);

        Herramienta::create([
            'nombre' => 'Rotopavela',
            'categoria' => 'Máquinas',
            'estado' => 'disponible',
        ]);

        Herramienta::create([
            'nombre' => 'Pulidor',
            'categoria' => 'Máquinas',
            'estado' => 'disponible',
        ]);

        Herramienta::create([
            'nombre' => 'Amoladora',
            'categoria' => 'Máquinas',
            'estado' => 'disponible',
        ]);

        // Herramientas
        Herramienta::create([
            'nombre' => 'Martillo',
            'categoria' => 'Herramientas',
            'estado' => 'disponible',
        ]);

        Herramienta::create([
            'nombre' => 'Llave Inglesa',
            'categoria' => 'Herramientas',
            'estado' => 'disponible',
        ]);

        Herramienta::create([
            'nombre' => 'Destornillador',
            'categoria' => 'Herramientas',
            'estado' => 'disponible',
        ]);

        Herramienta::create([
            'nombre' => 'Alicate',
            'categoria' => 'Herramientas',
            'estado' => 'disponible',
        ]);

        // Otros
        Herramienta::create([
            'nombre' => 'Escalera',
            'categoria' => 'Otros',
            'estado' => 'disponible',
        ]);
    }
}

