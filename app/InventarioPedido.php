<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class InventarioPedido extends Model
{
   protected $table = 'inventario_pedidos';

    protected $fillable = ['fecha_pedido', 'precio_venta_unidad', 'precio_total_pedido', 'cantidad_unida', 'cantidad_caja','pedido_id', 'inventario_id'];
}
