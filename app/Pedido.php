<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{

    protected $table = 'pedidos';

    protected $fillable = ['cantidad_unidad', 'cantidad_caja','precio_unidad','precio_total','fecha_pedido','estatus'];

    public function cliente()
    {
        return $this->belongsTo('Proyecto\Cliente');
    }

    /*public function inventario()
    {
        return $this->belongsTo('Proyecto\Inventario');
    }*/



    public function users()
    {
        return $this->belongsTo('Proyecto\Users');
    }

    public function inventarios(){
     return $this->belongsToMany('Proyecto\Inventario')
             ->withPivot('inventario_id', 'pedido_id')
             ->withTimestamps();
   }

   public function factura(){
    return $this->belongsToMany('Proyecto\Factura')
            ->withPivot('factura_id', 'pedido_id')
            ->withTimestamps();
  }
}
