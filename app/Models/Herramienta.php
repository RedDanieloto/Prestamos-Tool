<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'categoria',
        'estado',
    ];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    public function prestamoActivo()
    {
        return $this->hasOne(Prestamo::class)->where('estado', 'activo');
    }
}
