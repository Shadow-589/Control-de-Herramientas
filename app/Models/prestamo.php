<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table = 'prestamo';
    public $timestamps = false;


    protected $fillable = [
        'id_persona',
        'id_herramienta',
        'cantidad',
        'fecha_prestamo',
        'hora_prestamo',
        'fecha_devolucion',
        'devolucion_real',
        'estado',
        'comentarios'
    ];
    public function persona()
    {
        return $this->belongsTo(Personal::class, 'id_persona');
    }

    public function herramienta()
    {
        return $this->belongsTo(Herramienta::class, 'id_herramienta');
    }
}
