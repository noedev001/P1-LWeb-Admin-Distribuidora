<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class KadexGeneral extends Model
{
    protected $fillable = [ 'inventario_id','cantidad_unidad_entrada', 'cantidad_caja_entrada', 'precio_compra_unidad_entrada', 'precio_venta_unidad_entrada', 'cantidad_unidad_salida', 'cantidad_caja_salida', 'precio_compra_unidad_salida', 'precio_venta_unidad_salida',  'detalle_salida','cantidad_total', 'saldototal', 'status'];
    
    public function inventario()
    {
        return $this->belongsTo('Proyecto\Inventario');
    }
}
