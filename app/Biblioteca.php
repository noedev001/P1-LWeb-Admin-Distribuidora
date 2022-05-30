<?php

namespace Proyecto;

use Illuminate\Database\Eloquent\Model;

class Biblioteca extends Model
{
    protected $fillable = ['avatar', 'avatarurl'];

    public function producto()
    {
        return $this->belongsTo('Proyecto\Producto');
    }
}
