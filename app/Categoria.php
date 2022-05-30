<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nombre', 'descripcion'];


    public function producto()
    {
        return $this->hasMany('Proyecto\Producto');
    }
}
