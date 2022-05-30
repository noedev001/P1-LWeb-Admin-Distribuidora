<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class DatoCliente extends Model
{
  protected $fillable = [
      'direccion', 'celular', 'password',
  ];
  public function cliente()
  {
    return $this->belongsTo('Proyecto\Cliente');
  }
}
