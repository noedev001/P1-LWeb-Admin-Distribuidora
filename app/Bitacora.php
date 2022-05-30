<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $fillable = ['fecha_inicio', 'hora_inicio', 'fecha_salida', 'hora_salida', 'cliente_id'];
}
