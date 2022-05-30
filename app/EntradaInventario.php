<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class EntradaInventario extends Model
{

    
    protected $fillable = ['cantidad_unidad', 'cantidad_caja', 'precio_compra_unidad', 'precio_venta_unidad', 'inventario_id' ];
    
    public function inventario()
    {
        return $this->belongsTo('Proyecto\Inventario');
    }
}
