<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $fillable = ['nombre', 'marca', 'modelo', 'medida', 'serie', 'descripcion', 'avatar','avatarurl'];

      public function cateogoria()
      {
          return $this->belongsTo('Proyecto\Categoria');
      }

      public function inventario()
      {
          return $this->hasMany('Proyecto\Inventario');
      }

      public function registroinventario()
      {
          return $this->hasMany('Proyecto\RegistroInventario');
      }

      public function Biblioteca()
      {
          return $this->hasMany('Proyecto\Biblioteca');
      }
}
