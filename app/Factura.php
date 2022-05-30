<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
  protected $fillable = ['factura', 'fecha', 'cliente_id'];

    public function cliente()
      {
          return $this->belongsTo('Proyecto\Cliente');
      }


      public function pedidos()
      {
        return $this->belongsToMany('Proyecto\Pedido')
                    ->withTimestamps();
      }

}
