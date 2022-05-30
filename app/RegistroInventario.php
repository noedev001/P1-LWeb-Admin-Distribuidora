<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class RegistroInventario extends Model
{
  protected $fillable = ['catidad_unidad_caja', 'cantidad_unidad', 'cantidad_caja', 'precio_compra_unidad', 'precio_venta_unidad'];

    public function productos()
    {
        return $this->belongsTo('Proyecto\Productos');
    }
}
