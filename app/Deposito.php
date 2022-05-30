<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    protected $fillable = ['asunto', 'monto', 'foto', 'estado','fecha'];

    public function cliente()
    {
        return $this->belongsTo('Proyecto\Cliente');
    }
}
