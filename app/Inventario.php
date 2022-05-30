<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{

    protected $table = 'inventarios';

    protected $fillable = ['catidad_unidad_caja', 'cantidad_unidad', 'cantidad_caja', 'precio_compra_unidad', 'precio_venta_unidad','fecha_vencimiento'];

      public function productos()
      {
          return $this->belongsTo('Proyecto\Producto');
      }


      public function ofertas()
      {
          return $this->hasMany('Proyecto\Oferta');
      }

      /*public function pedido()
      {
          return $this->hasMany('Proyecto\Pedido');
      }*/

      public function pedidos()
      {
        return $this->belongsToMany('Proyecto\Pedido')
                    ->withTimestamps();
      }

      public function entradainventario()
      {
          return $this->hasMany('Proyecto\EntradaInventario');
      }

      public function salidainventario()
      {
          return $this->hasMany('Proyecto\SalidaInventario');
      }

      public function saldoinventario()
      {
          return $this->hasMany('Proyecto\SaldoInventario');
      }

      public function kardexinventario()
      {
          return $this->hasMany('Proyecto\KardexGeneral');
      }
}
