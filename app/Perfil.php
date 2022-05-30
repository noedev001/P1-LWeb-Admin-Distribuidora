<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
      protected $fillable = ['user_id', 'apellido','direccion','celular','avatar',];

      public function user()
      {
        return $this->belongsTo('Proyecto\User');
      }
}
