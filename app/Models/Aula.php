<?php

namespace App\Models;

use App\Models\Paralelo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cohorte;

class Aula extends Model
{
    
    protected $fillable = [
        'nombre',
        'piso',
        'codigo',
        'paralelos_id',
    ];

    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class, 'paralelos_id');
    }
    public function cohortes()
    {
        return $this->hasMany(Cohorte::class);
    }
}
