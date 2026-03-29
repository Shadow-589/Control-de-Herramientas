<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model
{
    use HasFactory;

    protected $table = 'herramientas';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'tipo',
        'datos',
        'cantidad',
        'estado_herramienta'
    ];
}
