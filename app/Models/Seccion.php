<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Secretario;
use App\Models\Maestria;
class Seccion extends Model
{
    protected $table = 'secciones';
    protected $fillable = ['nombre'];

    public function maestrias()
    {
        return $this->belongsToMany(Maestria::class);
    }

    public function secretarios()
    {
        return $this->belongsToMany(Secretario::class);
    }
}
