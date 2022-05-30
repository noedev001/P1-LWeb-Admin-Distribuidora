<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Asignar extends Model
{
  protected $fillable = ['nombre_user', 'rol_asignacion','nombre_sucursal',];

  public function user()
  {
    return $this->belongsTo('Proyecto\User');
  }
}
