<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{

  protected $fillable = ['unidad_almacen', 'caja_almacen', 'unidad_disponible', 'caja_disponible', 'precio_venta_nuevo'];


  public function inventario()
  {
      return $this->belongsTo('Proyecto\Inventario');
  }
}
