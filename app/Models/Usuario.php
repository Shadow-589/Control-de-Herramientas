<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'a_paterno',
        'a_materno',
        'telefono',
        'tipo',
        'foto',
        'correo',
        'password'
    ];
}
