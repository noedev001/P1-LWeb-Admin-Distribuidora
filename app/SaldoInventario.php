<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class SaldoInventario extends Model
{


    protected $fillable = ['cantidad_total', 'saldototal', 'status',  'inventario_id'];
    
    public function inventario()
    {
        return $this->belongsTo('Proyecto\Inventario');
    }
}
