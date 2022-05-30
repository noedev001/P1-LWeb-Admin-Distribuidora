<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    protected $fillable = ['nombre', 'fecha_entrega', 'hora','cliente_id','user_id'];

    public function cliente()
      {
          return $this->belongsTo('Proyecto\Cliente');
      }

      public function user()
      {
          return $this->belongsTo('Proyecto\User');
      }
}
