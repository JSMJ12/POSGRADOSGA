<?php

namespace App\Models;
use App\Models\Seccion;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class Secretario extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'contra',
        'sexo',
        'dni',
        'tipo',
        'image',
    ];
    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }
}
