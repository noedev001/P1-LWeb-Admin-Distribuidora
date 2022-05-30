<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{

    protected $fillable = ['forma_pago', 'fecha_pago', 'monto', 'foto_pago', 'pedido_id'];


    public function cliente()
    {
        return $this->belongsTo('Proyecto\Cliente');
    }
}
