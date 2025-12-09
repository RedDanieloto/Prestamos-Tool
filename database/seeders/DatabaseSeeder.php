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
        // Crear técnicos de ejemplo
        Tecnico::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan.perez@empresa.com',
            'telefono' => '555-0101',
            'departamento' => 'Mantenimiento',
            'activo' => true,
        ]);

        Tecnico::create([
            'nombre' => 'María',
            'apellido' => 'García',
            'email' => 'maria.garcia@empresa.com',
            'telefono' => '555-0102',
            'departamento' => 'Eléctrica',
            'activo' => true,
        ]);

        Tecnico::create([
            'nombre' => 'Carlos',
            'apellido' => 'López',
            'email' => 'carlos.lopez@empresa.com',
            'telefono' => '555-0103',
            'departamento' => 'Mecánica',
            'activo' => true,
        ]);

        // Crear herramientas de ejemplo
        Herramienta::create([
            'nombre' => 'Taladro Eléctrico',
            'codigo' => 'HER-001',
            'descripcion' => 'Taladro eléctrico industrial 800W',
            'categoria' => 'Eléctrica',
            'estado' => 'disponible',
        ]);

        Herramienta::create([
            'nombre' => 'Multímetro Digital',
            'codigo' => 'HER-002',
            'descripcion' => 'Multímetro digital con pantalla LCD',
            'categoria' => 'Medición',
            'estado' => 'disponible',
        ]);

        Herramienta::create([
            'nombre' => 'Llave Inglesa 12"',
            'codigo' => 'HER-003',
            'descripcion' => 'Llave inglesa ajustable 12 pulgadas',
            'categoria' => 'Mecánica',
            'estado' => 'disponible',
        ]);

        Herramienta::create([
            'nombre' => 'Soldadora MIG',
            'codigo' => 'HER-004',
            'descripcion' => 'Soldadora MIG 220V',
            'categoria' => 'Soldadura',
            'estado' => 'disponible',
        ]);

        Herramienta::create([
            'nombre' => 'Calibrador Vernier',
            'codigo' => 'HER-005',
            'descripcion' => 'Calibrador Vernier digital 0-150mm',
            'categoria' => 'Medición',
            'estado' => 'disponible',
        ]);

        Herramienta::create([
            'nombre' => 'Amoladora Angular',
            'codigo' => 'HER-006',
            'descripcion' => 'Amoladora angular 4.5" 750W',
            'categoria' => 'Eléctrica',
            'estado' => 'disponible',
        ]);
    }
}

