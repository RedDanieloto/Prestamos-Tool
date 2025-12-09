<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tecnico_id',
        'herramienta_id',
        'fecha_prestamo',
        'fecha_devolucion',
        'notas',
        'estado',
    ];

    protected $casts = [
        'fecha_prestamo' => 'datetime',
        'fecha_devolucion' => 'datetime',
    ];

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }

    public function herramienta()
    {
        return $this->belongsTo(Herramienta::class);
    }
}
